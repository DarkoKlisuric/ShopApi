<?php

namespace App\Controller\User;

use App\Controller\ApiController;
use App\Entity\User;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class RegistrationController
 * @package App\Controller\User
 */
class RegistrationController extends ApiController
{
    /**
     * @param Request $request
     * @param UserService $service
     * @return Response
     */
    public function register(Request $request, UserService $service)
    {
        $object = null;

        // Deserialization of object
        try {
            /** @var User $object */
            $object = $this->getRequestSerializer()->deserialize($request->getContent(), User::class, ['create']);
        } catch (HttpException $exception) {
            return $this->respondValidationError($exception->getMessage());
        }

        // Persist user into db
        $service->create($object);

        return $this->respondCreated($object);
    }
}