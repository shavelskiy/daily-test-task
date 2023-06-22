<?php

declare(strict_types=1);

namespace App\Tests\Controller\Security;

use App\DataFixtures\UserFixtures;
use App\Tests\Controller\AbstractControllerTestCase;

class AuthControllerTest extends AbstractControllerTestCase
{
    private const URL = '/v1/security/auth';

    public function testAuth(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
        ]);

        $this->postRequest(self::URL, [
            'email' => 'user@user.user',
            'password' => 'user',
        ]);

        $response = $this->getClientResponse();

        self::assertSame(strlen((string)$response['token']) > 0, true);
    }

    public function testAuthWrongPasswrod(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
        ]);

        $this->postRequest(self::URL, [
            'email' => 'user@user.user',
            'password' => 'wrong-password',
        ]);

        $response = $this->getClientResponse(400);

        self::assertSame($response['code'], 201);
    }

    public function testAuthBlockUser(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
        ]);

        $this->postRequest(self::URL, [
            'email' => 'block-user@user.user',
            'password' => 'block',
        ]);

        $response = $this->getClientResponse(403);

        self::assertSame($response['code'], 203);
    }
}
