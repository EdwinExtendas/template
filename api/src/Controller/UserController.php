<?php

namespace App\Controller;

use App\Command\MobyPayUserRegistrationCommand;
use App\Entity\LocalCard;
use App\Entity\Organization;
use App\Entity\AppUser;
use App\Form\Validation\Api\App\UserRegisterDTOType;
use App\Repository\PortalUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\JobQueueBundle\Entity\Job;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserController.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class UserController extends BaseController
{
    /**
     * #TODO: temporary, delete this before production.
     *
     * @Route(
     *     "/pin/{id}/{pass}",
     *     name="getcards",
     *     methods={"GET"}
     * )
     *
     * @param \App\Entity\AppUser $user
     * @param $pass
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $password_encoder
     * @param \Doctrine\ORM\EntityManagerInterface                                  $em
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changePassword(AppUser $user, $pass, UserPasswordEncoderInterface $password_encoder, EntityManagerInterface $em)
    {
        $user->setPassword($password_encoder->encodePassword($user, $pass));
        $user->setRoles([AppUser::ROLE_ADMIN]);
        $em->flush();

        return new Response('Password updated');
    }

    /**
     * @Route(
     *     "/user/register",
     *     name="user_register",
     *     methods={"POST"}
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Creates an AppUser and registers it with MobyPay.",
     *     @SWG\Schema(
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="message", type="string")
     *          )
     *     )
     * )
     * @SWG\Parameter(
     *     name="Register",
     *     in="body",
     *     @SWG\Schema(
     *         @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="api_code", type="string"),
     *              @SWG\Property(property="email", type="string"),
     *              @SWG\Property(property="phone_number", type="string"),
     *              @SWG\Property(property="pan", type="string"),
     *              @SWG\Property(property="card_number", type="string")
     *          )
     *     )
     * )
     * @SWG\Tag(name="AppUser")
     *
     * @param \Symfony\Component\HttpFoundation\Request                             $request
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $encoder
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Symfony\Component\Form\Exception\RuntimeException
     * @throws \UnexpectedValueException
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user_data = $this->formValidatePostData($request, UserRegisterDTOType::class);

        $em = $this->getDoctrine()->getManager();

        //check if user already exists
        $user_exists = $em->getRepository(AppUser::class)->findUser($user_data->email, $user_data->phone_number);
        if ($user_exists)
        {
            return new JsonResponse(['message' => 'AppUser already exists'], 409);
        }

        //check if organization exists
        /** @var Organization $organization */
        $organization = $em->getRepository(Organization::class)->findOneBy(['fo_api_code' => $user_data->api_code]);
        if (!$organization)
        {
            return new JsonResponse(['message' => 'No organization found with given api_code'], 404);
        }

        $user = AppUser::createFromRegisterDTO($user_data, $organization);

        // can't do in constructor because the encoder needs the UserInterface.
        $user->setPassword($encoder->encodePassword($user, $this->randomString(40)));

        //create local_card
        $local_card = LocalCard::createFromRegisterDTO($user_data, $user);

        $em->persist($local_card);
        $em->persist($user);
        $em->flush();

        //schedule register mobypay user job if previous entities save correctly;
        $job = new Job(MobyPayUserRegistrationCommand::COMMAND_NAME, ['--user=' . $user->getId()]);
        $em->persist($job);
        $em->flush();

        return new JsonResponse(['message' => 'Successfully registered!']);
    }

    /**
     * @Route("/token/portal/login",
     *     name="user_cms_login",
     *     methods={"POST"}
     * )
     *
     * @param \Symfony\Component\HttpFoundation\Request                               $request
     * @param \Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface $token_manager
     * @param \App\Repository\PortalUserRepository                                    $user_repository
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface   $user_password_encoder
     * @param $cms_cors_domain
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function portalLoginAction(
        Request $request,
        JWTTokenManagerInterface $token_manager,
        PortalUserRepository $user_repository,
        UserPasswordEncoderInterface $user_password_encoder,
        $cms_cors_domain
    ) {
        $data = json_decode($request->getContent(), true);
        if (!$data)
        {
            return new JsonResponse(['message' => 'Invalid JSON sent.'], 400);
        }

        if (!isset($data['username']) || !isset($data['password']))
        {
            return new JsonResponse(['message' => 'Username or password not given'], 400);
        }

        /** @var \App\Entity\PortalUser $user */
        $user = $user_repository->loadUserByUsername($data['username']);
        if (!$user)
        {
            return new JsonResponse(['message' => 'No user found with given details'], 404);
        }

        if (!$user_password_encoder->isPasswordValid($user, $data['password']))
        {
            return new JsonResponse(['message' => 'No user found with given details'], 404);
        }

        $token = $token_manager->create($user);

        $response = new JsonResponse([
            'success' => true,
        ]);

        // set the HttpOnly cookie with the token
        $response->headers->setCookie(
            new Cookie(
                'token',
                $token,
                0,
                '/',
                $cms_cors_domain
            )
        );

        $user_data = [
            'username' => $data['username'],
            'admin' => $user->isAdmin(),
        ];

        // set the user data cookie
        $response->headers->setCookie(
            new Cookie(
                'user',
                base64_encode(json_encode($user_data)),
                0,
                '/',
                $cms_cors_domain,
                false,
                false
            )
        );

        return $response;
    }
}
