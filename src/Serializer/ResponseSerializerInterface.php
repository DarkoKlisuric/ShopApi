<?php

namespace App\Serializer;

/**
 * Interface ResponseSerializerInterface
 * @package App\Serializer
 */
interface ResponseSerializerInterface
{
    /**
     * @param array|object $model
     * @param string $groups
     * @return string
     */
    public function serialize($model, string $groups): string;
}