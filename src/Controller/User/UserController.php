<?php

namespace App\Controller\User;

use App\Controller\ApiController;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserController
 * @package App\Controller\User
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends ApiController
{
    /**
     * @param User|null $user
     * @return JsonResponse
     */
    public function show(?User $user)
    {
        if (null !== $user) {
            $response = $this->getResponseUtil()->serialize($user, 'show');

            return $this->response($response, ['Content-Type' => 'application/json']);
        }

        return $this->respondNotFound();
    }

    public function list()
    {

    }
}