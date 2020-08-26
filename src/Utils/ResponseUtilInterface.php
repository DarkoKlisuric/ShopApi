<?php

namespace App\Utils;

/**
 * Interface ResponseUtilInterface
 * @package App\Utils
 */
interface ResponseUtilInterface
{
    /**
     * @param object $model
     * @param string $groups
     * @return string
     */
    public function serialize(object $model, string $groups): string;
}