<?php

namespace App\Repository;

use App\Entity\AppUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method AppUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppUser[]    findAll()
 * @method AppUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppUserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AppUser::class);
    }

    /**
     * Loads the user for the given username.
     *
     * This method must return null if the user is not found.
     *
     * @param $email
     *
     * @return UserInterface|null
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function loadUserByUsername($email)
    {
        return $this->createQueryBuilder('u')
            ->select('u', 'o')
            ->where('u.email = :query')
            ->join('u.organization', 'o')
            ->setParameter('query', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getUserWithOrganization($user_id)
    {
        return $this->createQueryBuilder('u')
            ->select('u', 'o')
            ->where('u.id = :user_id')
            ->join('u.organization', 'o')
            ->setParameter('user_id', $user_id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findUser($email, $phone_number)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->orWhere('u.phone_number = :phone_number')
            ->setParameters([
                'email' => $email,
                'phone_number' => $phone_number,
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}
