<?php

declare(strict_types=1);

namespace App\Tests\Controller\Security;

use App\DataFixtures\UserFixtures;
use App\Tests\Controller\AbstractControllerTestCase;

class UserControllerTest extends AbstractControllerTestCase
{
    private const URL = '/v1/security/user';

    public function testUser(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
        ]);

        $this->auth();

        $this->request(self::URL);

        $response = $this->getClientResponse();

        self::assertSame($response['email'], 'user@user.user');
    }

    public function testUserNotAuth(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
        ]);

        $this->request(self::URL);

        $response = $this->getClientResponse(401);

        self::assertSame($response['code'], 202);
    }
}
