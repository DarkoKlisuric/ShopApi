<?php

namespace App\Serializer;

/**
 * Interface RequestUtilInterface
 * @package App\Utils
 */
interface RequestUtilInterface
{
    public function deserialize(string $data, string $model, array $groups = []): object;
}