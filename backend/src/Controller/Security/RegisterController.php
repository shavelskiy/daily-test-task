<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Api\Request\Security\RegisterRequest;
use App\Api\Response\Security\AuthTokenResponse;
use App\Controller\AbstractController;
use App\Service\Security\AuthTokenService;
use App\Service\Security\SecurityService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/security/register", methods="POST")
 */
class RegisterController extends AbstractController
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

    public function __invoke(RegisterRequest $request): Response
    {
        $user = $this->securityService->register($request);

        $authToken = $this->authTokenService->getAuthToken($user);

        return new JsonResponse(
            new AuthTokenResponse($authToken),
        );
    }
}
