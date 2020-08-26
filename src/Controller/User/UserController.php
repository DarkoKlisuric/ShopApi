<?php

namespace App\Controller\User;

use App\Controller\ApiController;
use App\Entity\User;
use App\Services\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $response = $this->getResponseSerializer()->serialize($user, 'show');

            return $this->response($response, ['Content-Type' => 'application/json']);
        }

        return $this->respondNotFound();
    }

    public function list(UserService $service)
    {
        $users = $service->findAll();
    }
}