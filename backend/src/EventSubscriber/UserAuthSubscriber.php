<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Repository\AuthTokenRepository;
use App\Service\Security\UserStorage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserAuthSubscriber implements EventSubscriberInterface
{
    private AuthTokenRepository $authTokenRepository;
    private UserStorage $userStorage;

    public function __construct(
        AuthTokenRepository $authTokenRepository,
        UserStorage $userStorage
    ) {
        $this->authTokenRepository = $authTokenRepository;
        $this->userStorage = $userStorage;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onRequest',
        ];
    }

    public function onRequest(RequestEvent $event): void
    {
        if (($authHeader = $event->getRequest()->headers->get('Authorization')) === null) {
            return;
        }

        preg_match('/Bearer (.*)/', $authHeader, $match);

        if (count($match) < 1) {
            return;
        }

        if (($authToken = $this->authTokenRepository->findByToken($match[1])) === null) {
            return;
        }

        $this->userStorage->setAuthToken($authToken);
    }
}
