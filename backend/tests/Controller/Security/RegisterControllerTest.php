<?php

declare(strict_types=1);

namespace App\Tests\Controller\Security;

use App\DataFixtures\UserFixtures;
use App\Tests\Controller\AbstractControllerTestCase;

class RegisterControllerTest extends AbstractControllerTestCase
{
    private const URL = '/v1/security/register';

    public function testRegister(): void
    {
        $this->postRequest(self::URL, [
            'email' => 'new@user.ru',
            'password' => 'pass',
        ]);

        $response = $this->getClientResponse();

        self::assertSame(strlen((string)$response['token']) > 0, true);
    }

    public function testRegisterExists(): void
    {
        $this->databaseTool->loadFixtures([
            UserFixtures::class,
        ]);

        $this->postRequest(self::URL, [
            'email' => 'user@user.user',
            'password' => 'pass',
        ]);

        $response = $this->getClientResponse(400);

        self::assertSame($response['code'], 200);
    }
}
