<?php

namespace App\Services;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\Exception\InvalidArgumentException;

/**
 * Class DataManipulationService
 * @package App\Services
 */
abstract class DataManipulationService extends Service
{
    private string $entityNamespace = 'App\\Entity';

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * Optional method if entities are not in App\Entity
     * @param $entityNamespace
     */
    public function setEntityNamespace($entityNamespace)
    {
        $this->entityNamespace = $entityNamespace;
    }

    /**
     * In this method you must define collections of entity which you want to delete.
     * For instance, user have products collection, favorite product collection etc.
     * Method must return [Product::class, FavoriteProduct::class]
     *
     * If entity does not have collections, return empty array []
     * @return array
     */
    protected abstract function collections(): array;

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
        $collections = $this->collections();

        // If entity have collections
        if (!empty($collections)) {
            $this->removeCollection($entity, $collections);
        }
        // Remove main requested entity
        $this->removeEntity($entity);

        try {
            $this->entityManager->flush();
        } catch (ForeignKeyConstraintViolationException $exception) {
            $exception->getErrorCode();
        }
    }

    /**
     * Remove single entity from DB
     * @param object $entity
     */
    private function removeEntity(object $entity)
    {
        $this->entityManager->remove($entity);
    }

    /**
     * @param object $entity
     * @param array $collections
     */
    private function removeCollection(object $entity, array $collections)
    {
        foreach ($collections as $collection) {
            // If arguments are valid
            if (class_exists($collection) && strpos($collection, $this->getEntityNamespace()) === 0) {

                // Find all related entities
                $entities = $this->entityManager->getRepository($collection)->findBy([$entity->getRelationName() => $entity]);

                // Remove entities from DB
                $this->removeEntitiesCollection($entities);
            }
            throw new InvalidArgumentException('Invalid arguments');
        }
    }

    /**
     * Remove entities from DB
     *
     * @param array $entities
     */
    private function removeEntitiesCollection(array $entities)
    {
        foreach ($entities as $entity) {
            $this->removeEntity($entity);
        }
    }
}