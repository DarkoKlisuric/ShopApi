<?php

namespace App\Controller\User;

use App\Controller\ApiController;
use App\Entity\User;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class RegistrationController
 * @package App\Controller\User
 */
class RegistrationController extends ApiController
{
    public function register(Request $request, UserService $service)
    {
        $object = null;

        try {
            /** @var User $object */
            $object = $this->getRequestUtil()->validate($request->getContent(), User::class);
        } catch (HttpException $exception) {
            return $this->respondValidationError($exception->getMessage());
        }

        if (null !== $object) {
            $service->create($object);
        }

        return $this->respondCreated($object);
    }
}