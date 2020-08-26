<?php

namespace App\Serializer;

/**
 * Interface RequestSerializerInterface
 * @package App\Serializer
 */
interface RequestSerializerInterface
{
    public function deserialize(string $data, string $model, array $groups = []): object;
}