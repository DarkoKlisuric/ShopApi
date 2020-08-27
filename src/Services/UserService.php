<?php

namespace App\Services;

use App\Entity\User;
use App\Enums\RoleEnum;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserService
 * @package App\Services
 */
class UserService extends DataManipulationService
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * UserService constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $userRepository
     */
    public function __construct(EntityManagerInterface $entityManager,
                                UserPasswordEncoderInterface $passwordEncoder,
                                UserRepository $userRepository)
    {
        parent::__construct($entityManager);

        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
    }

    protected function collections(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->userRepository->getAll();
    }

    /**
     * @param User $user
     */
    public function create(User $user)
    {
        $this->setData($user);

        $this->save($user);
    }

    /**
     * @param User $user
     */
    public function update(User $user)
    {
        $this->setData($user);

        $this->save($user, true);
    }

    /**
     * @param User $user
     */
    private function setData(User $user)
    {
        $plainPassword = $this->passwordEncoder->encodePassword(
            $user,
            $user->getPlainPassword()
        );

        $user->setPassword($plainPassword)
            ->setRoles([RoleEnum::ROLE_USER]);

        $user->eraseCredentials();
    }

    /**
     * @param User $user
     */
    public function delete(User $user)
    {
        $this->remove($user);
    }
}