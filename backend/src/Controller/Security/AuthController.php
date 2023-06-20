<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Api\Request\Security\AuthRequest;
use App\Api\Response\Security\AuthTokenResponse;
use App\Controller\AbstractController;
use App\Service\Security\AuthTokenService;
use App\Service\Security\SecurityService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/security/auth", methods="POST")
 */
class AuthController extends AbstractController
{
    private SecurityService $securityService;
    private AuthTokenService $authTokenService;

    public function __construct(
        SecurityService $securityService,
        AuthTokenService $authTokenService
    ) {
        $this->securityService = $securityService;
        $this->authTokenService = $authTokenService;
    }

    public function __invoke(AuthRequest $request): Response
    {
        $user = $this->securityService->auth($request);

        $authToken = $this->authTokenService->getAuthToken($user);

        return new JsonResponse(
            new AuthTokenResponse($authToken),
        );
    }
}
