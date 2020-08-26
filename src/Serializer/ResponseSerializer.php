<?php

namespace App\Serializer;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ResponseSerializer
 * @package App\Searializer
 */
class ResponseSerializer implements ResponseSerializerInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * ResponseSerializer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array|object $model
     * @param string $groups
     * @return string
     */
    public function serialize($model, string $groups = ''): string
    {
        return $this->serializer->serialize($model, 'json', ['groups' => $groups]);
    }
}