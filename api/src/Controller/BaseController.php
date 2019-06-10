<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class BaseController.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
abstract class BaseController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param string                                    $form_class
     *
     * @return mixed
     *
     * @throws \Symfony\Component\Form\Exception\RuntimeException
     */
    public function formValidatePostData(Request $request, string $form_class)
    {
        $data = json_decode($request->getContent(), true);
        if (!$data)
        {
            throw new \InvalidArgumentException('Invalid JSON sent.');
        }

        // DTO & Form Validation.
        $form = $this->createForm($form_class);
        $form->submit($data);
        if (!$form->isSubmitted() || !$form->isValid())
        {
            throw new \InvalidArgumentException(json_encode($this->getFormErrors($form)));
        }

        return $form->getData();
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return string
     */
    public function getFormErrors(FormInterface $form): array
    {
        $errors = [];
        // Global
        foreach ($form->getErrors() as $error)
        {
            $errors[$form->getName()][] = $error->getMessage();
        }
        // Fields
        foreach ($form as $child /* @var Form $child */)
        {
            if (!$child->isValid())
            {
                foreach ($child->getErrors() as $error)
                {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }

        return $errors;
    }

    public function returnFormErrors(FormInterface $form)
    {
        return new JsonResponse($this->getFormErrors($form));
    }

    /**
     * @param \Symfony\Component\Serializer\SerializerInterface $serializer
     * @param $data
     * @param bool $public_group
     *
     * @return Response
     */
    public function jsonResponse(SerializerInterface $serializer, $data, $public_group = true)
    {
        return new Response(
            $serializer->serialize(
                $data,
                'json',
                $public_group ? ['groups' => 'public'] : []
            ),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public function randomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; ++$i)
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
