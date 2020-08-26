<?php

namespace App\Utils;

use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestUtil
 * @package App\Utils
 */
class RequestUtil
{
    /** @var SerializerInterface  */
    private SerializerInterface $serializer;

    /** @var ValidatorInterface  */
    private ValidatorInterface $validator;

    /**
     * RequestUtil constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param string $data
     * @param string $model
     * @return object
     */
    public function validate(string $data, string $model): object
    {
        if (!$data) {
            throw new BadRequestHttpException('Empty body.');
        }

        try {
            $object = $this->serializer->deserialize($data, $model, 'json');
        } catch (Exception $e) {
            throw new BadRequestHttpException('Invalid body.');
        }

        $errors = $this->validator->validate($object);

        if ($errors->count()) {
            throw new BadRequestHttpException(json_encode($errors));
        }

        return $object;
    }
}