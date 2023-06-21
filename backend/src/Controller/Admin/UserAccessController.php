<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Api\Request\Admin\AdminAccessRequest;
use App\Controller\ControllerInterface;
use App\Service\Admin\AdminUserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

/**
 * @Route(path="/admin/user/access/{id}", methods="POST")
 */
class UserAccessController implements ControllerInterface
{
    private AdminUserService $userService;

    public function __construct(
        AdminUserService $userService
    ) {
        $this->userService = $userService;
    }

    public function __invoke(string $id, AdminAccessRequest $request): Response
    {
        $this->userService->changeAccess(Uuid::fromString($id), $request);

        return new JsonResponse();
    }
}
