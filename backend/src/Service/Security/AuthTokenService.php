<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Entity\AuthToken;
use App\Entity\User;
use App\Repository\AuthTokenRepository;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class AuthTokenService
{
    private const EXPIRES_IN = 36000;
    private const SECRET = 'KEOtMVjqnW';

    private AuthTokenRepository $authTokenRepository;

    public function __construct(
        AuthTokenRepository $authTokenRepository
    ) {
        $this->authTokenRepository = $authTokenRepository;
    }

    public function getAuthToken(User $user): AuthToken
    {
        if (($authToken = $this->authTokenRepository->findActiveToken($user)) !== null) {
            return $authToken;
        }

        $authToken = new AuthToken(
            $user,
            $this->generateToken($user->getId()),
            $this->generateExpiresAt()
        );

        $this->authTokenRepository->save($authToken);

        return $authToken;
    }

    private function generateExpiresAt(): DateTimeImmutable
    {
        return (new DateTimeImmutable())->setTimestamp(time() + self::EXPIRES_IN);
    }

    private function generateToken(Uuid $userId): string
    {
        $headersEncoded = $this->partEncode(md5((string)Uuid::v4()));
        $payloadEncoded = $this->partEncode((string)$userId);
        $signature = sprintf('%s.%s', $headersEncoded, $payloadEncoded);

        $signatureEncoded = self::partEncode(hash_hmac('SHA256', $signature, self::SECRET, true));

        return sprintf('%s.%s', $signature, $signatureEncoded);
    }

    private function partEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
