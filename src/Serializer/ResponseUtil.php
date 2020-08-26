<?php

namespace App\Serializer;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ResponseUtil
 * @package App\Utils
 */
class ResponseUtil implements ResponseUtilInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * ResponseUtil constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param object $model
     * @param string $groups
     * @return string
     */
    public function serialize(object $model, string $groups = ''): string
    {
        return $this->serializer->serialize($model, 'json', ['groups' => $groups]);
    }
}