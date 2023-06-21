<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Api\Response\Security\UserResponse;
use App\Controller\ControllerInterface;
use App\Service\Admin\AdminUserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/admin/user", methods="GET")
 */
class UserListController implements ControllerInterface
{
    private AdminUserService $userService;

    public function __construct(
        AdminUserService $userService
    ) {
        $this->userService = $userService;
    }

    public function __invoke(): Response
    {
        $result = [];

        foreach ($this->userService->getList() as $user) {
            if (!$user->isAdmin()) {
                $result[] = new UserResponse($user);
            }
        }

        return new JsonResponse($result);
    }
}
