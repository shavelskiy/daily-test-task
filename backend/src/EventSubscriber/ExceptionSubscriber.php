<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Exception\BaseException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = new JsonResponse([
            'message' => $exception->getMessage(),
            'code' => $exception instanceof BaseException ? $exception->getCode() : null,
        ], $this->getStatusCode($exception));

        $event->setResponse($response);

        $this->log($exception);
    }

    private function getStatusCode(Throwable $exception): int
    {
        if ($exception instanceof HttpException) {
            return $exception->getStatusCode();
        }

        if ($exception instanceof BaseException) {
            return $exception->getStatusCode();
        }

        return 400;
    }

    private function log(Throwable $e): void
    {
        if ($e instanceof BaseException) {
            $this->logger->error(sprintf('code: %s. message: %s', $e->getCode(), $e->getMessage()));
            return;
        }

        $this->logger->critical($e->getMessage());
    }
}
