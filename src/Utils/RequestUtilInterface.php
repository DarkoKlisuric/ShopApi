<?php

namespace App\Utils;

/**
 * Interface RequestUtilInterface
 * @package App\Utils
 */
interface RequestUtilInterface
{
    public function validate(string $data, string $model): object;
}