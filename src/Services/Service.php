<?php

namespace App\Services;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Service
 * @package App\Services
 */
abstract class Service
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * Service constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param object $entity
     * @param bool $update
     * @return void
     */
    protected function save(object $entity, $update = false)
    {
        if (!$update) {
            $this->entityManager->persist($entity);
        }
        $this->entityManager->flush();
    }

    /**
     * @param object $entity
     */
    protected function remove(object $entity)
    {
        $this->entityManager->remove($entity);

        try {
            $this->entityManager->flush();
        } catch (ForeignKeyConstraintViolationException $exception) {
            $exception->getErrorCode();
        }
    }
}