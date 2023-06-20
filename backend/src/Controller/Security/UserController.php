<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Api\Response\Security\UserResponse;
use App\Controller\AbstractController;
use App\Service\Security\UserStorage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/security/user", methods="GET")
 */
class UserController extends AbstractController
{
    private UserStorage $userStorage;

    public function __construct(
        UserStorage $userStorage
    ) {
        $this->userStorage = $userStorage;
    }

    public function __invoke(): Response
    {
        return new JsonResponse(
            new UserResponse($this->userStorage->getUser()),
        );
    }
}
