<?php

namespace App\Controller\User;

use App\Controller\ApiController;
use App\Entity\User;
use App\Services\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package App\Controller\User
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends ApiController
{
    /**
     * @param User|null $user
     * @return Response
     */
    public function show(?User $user)
    {
        if (null !== $user) {
            $response = $this->getResponseSerializer()->serialize($user, 'get');

            return $this->response($response);
        }

        // If user not exists, return HTTP_NOT_FOUND
        return $this->respondNotFound();
    }

    /**
     * @param UserService $service
     * @return Response
     */
    public function list(UserService $service)
    {
        // All users with role "ROLE_USER"
        $users = $service->findAll();

        // Searialize array of user objects
        $response = $this->getResponseSerializer()->serialize($users, 'get');

        return $this->response($response);
    }
}