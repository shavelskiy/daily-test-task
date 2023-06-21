<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\ControllerInterface;
use App\Service\Admin\AdminUserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

/**
 * @Route(path="/admin/user/{id}", methods="DELETE")
 */
class UserDeleteController implements ControllerInterface
{
    private AdminUserService $userService;

    public function __construct(
        AdminUserService $userService
    ) {
        $this->userService = $userService;
    }

    public function __invoke(string $id): Response
    {
        $this->userService->delete(Uuid::fromString($id));

        return new JsonResponse();
    }
}
