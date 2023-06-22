<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractControllerTestCase extends WebTestCase
{
    protected AbstractDatabaseTool $databaseTool;

    private KernelBrowser $client;
    private ?string $token = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();

        /** @var DatabaseToolCollection $databaseToolCollection */
        $databaseToolCollection = static::getContainer()->get(DatabaseToolCollection::class);
        $this->databaseTool = $databaseToolCollection->get();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
        $this->token = null;
    }

    protected function request(string $url): void
    {
        $this->client->request(
            'GET',
            $url,
            [],
            [],
            $this->token !== null ? [
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $this->token),
            ] : [],
        );
    }

    protected function auth(): void
    {
        $this->postRequest('/v1/security/auth', [
            'email' => 'user@user.user',
            'password' => 'user',
        ]);

        $respone = $this->getClientResponse();
        $this->token = (string)$respone['token'];
    }

    protected function postRequest(string $url, array $body = []): void
    {
        $this->processRequest('POST', $url, $body);
    }

    protected function deleteRequest(string $url): void
    {
        $this->processRequest('DELETE', $url, []);
    }

    protected function getClientResponse(int $status = 200): array
    {
        self::assertResponseStatusCodeSame($status);

        if (($content = $this->client->getResponse()->getContent()) === false) {
            return [];
        }

        if (!is_array($result = json_decode($content, true))) {
            return [];
        }

        return $result;
    }

    private function processRequest(string $method, string $url, array $body): void
    {
        $this->client->jsonRequest(
            $method,
            $url,
            $body,
            $this->token !== null ? [
                'HTTP_AUTHORIZATION' => sprintf('Bearer %s', $this->token),
            ] : [],
        );
    }
}
