<?php

namespace App\Serializer;

/**
 * Interface ResponseSerializerInterface
 * @package App\Serializer
 */
interface ResponseSerializerInterface
{
    /**
     * @param object $model
     * @param string $groups
     * @return string
     */
    public function serialize(object $model, string $groups): string;
}