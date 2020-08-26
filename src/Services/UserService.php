<?php

namespace App\Services;

use App\Entity\User;
use App\Enums\RoleEnum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService extends Service
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * UserService constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($entityManager);

        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     */
    public function create(User $user)
    {
        $em = $this->getEntityManager();

        $plainPassword = $this->passwordEncoder->encodePassword(
            $user,
            $user->getPlainPassword()
        );

        $user->setPassword($plainPassword)
            ->setRoles([RoleEnum::ROLE_USER]);

        $em->persist($user);
        $em->flush();;
    }
}