<?php

namespace App\DataFixtures;

use App\DTO\Validation\Api\App\UserRegisterDTO;
use App\Entity\PortalUser;
use App\Entity\AppUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixture.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class UserFixture extends Fixture implements DependentFixtureInterface
{
    public const USER_REFERENCE = 'normal-user';

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            OrganizationFixture::class,
        ];
    }

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $user_dto = new UserRegisterDTO();
        $user_dto->email = 'test@test.nl';
        $user_dto->phone_number = '0';
        $user_dto->api_code = 'VIS';

        /** @var \App\Entity\Organization $organization */
        $organization = $this->getReference(OrganizationFixture::ORGANIZATION_REFERENCE);

        $user = AppUser::createFromRegisterDTO($user_dto, $organization);
        $user->setPassword($this->encoder->encodePassword($user, 'test'));
        $user->setRoles([AppUser::ROLE_PHONE, AppUser::ROLE_ADMIN]);

        $this->addReference(self::USER_REFERENCE, $user);

        $manager->persist($user);

        $user2 = new PortalUser('test');
        $user2->setPassword($this->encoder->encodePassword($user2, 'test'));
        $user2->setOrganization($organization);
        $user2->setRoles([AppUser::ROLE_PORTAL, AppUser::ROLE_ADMIN]);

        $this->addReference(self::USER_REFERENCE . '-cms-admin', $user2);

        $manager->persist($user2);

        $user3 = new PortalUser('test2');
        $user3->setPassword($this->encoder->encodePassword($user2, 'test'));
        $user3->setOrganization($organization);
        $user3->setRoles([AppUser::ROLE_PORTAL]);

        $this->addReference(self::USER_REFERENCE . '-cms-user', $user3);

        $manager->persist($user3);
        $manager->flush();
    }
}
