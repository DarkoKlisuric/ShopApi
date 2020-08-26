<?php

namespace App\Repository;

use App\Entity\User;
use App\Enums\RoleEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[]|array
     */
    public function getAll()
    {
        return $this->findBy(['roles' => [RoleEnum::ROLE_USER]]);
    }
}