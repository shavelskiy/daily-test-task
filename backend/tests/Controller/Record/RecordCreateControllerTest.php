<?php

declare(strict_types=1);

namespace App\Tests\Controller\Record;

use App\DataFixtures\RecordFixtures;
use App\Tests\Controller\AbstractControllerTestCase;
use DateTimeImmutable;

class RecordCreateControllerTest extends AbstractControllerTestCase
{
    private const URL = '/v1/record';

    public function testRecordCreate(): void
    {
        $this->databaseTool->loadFixtures([
            RecordFixtures::class,
        ]);

        $this->auth();

        $this->postRequest(self::URL, [
            'text' => 'test record',
            'date' => (new DateTimeImmutable())->format('c'),
            'files' => [],
        ]);

        /** @var array{text: string, user: array} $response */
        $response = $this->getClientResponse();

        self::assertSame($response['text'], 'test record');
        self::assertSame($response['user']['email'], 'user@user.user');
    }
}
