<?php

namespace App\Repository;

use App\Entity\PortalUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method PortalUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortalUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortalUser[]    findAll()
 * @method PortalUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortalUserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PortalUser::class);
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
            ->select('u')
            ->where('u.username = :query')
            ->setParameter('query', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
