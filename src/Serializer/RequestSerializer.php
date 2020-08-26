<?php

namespace App\Serializer;

use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestSerializer
 * @package App\Searializer
 */
final class RequestSerializer implements RequestSerializerInterface
{
    /** @var SerializerInterface  */
    private SerializerInterface $serializer;

    /** @var ValidatorInterface  */
    private ValidatorInterface $validator;

    /**
     * RequestSerializer constructor.
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
     * @param array $groups
     * @return null|object
     */
    public function deserialize(string $data, string $model, array $groups = []): object
    {
        $object = null;

        if (!$data) {
            throw new BadRequestHttpException('Empty body.');
        }

        try {
            $object = $this->serializer->deserialize($data, $model, 'json', ['groups' => $groups]);
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