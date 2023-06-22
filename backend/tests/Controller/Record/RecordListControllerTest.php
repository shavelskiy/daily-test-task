<?php

declare(strict_types=1);

namespace App\Tests\Controller\Record;

use App\DataFixtures\RecordFixtures;
use App\Tests\Controller\AbstractControllerTestCase;
use DateTimeImmutable;

class RecordListControllerTest extends AbstractControllerTestCase
{
    private const URL = '/v1/record';

    public function testRecordList(): void
    {
        $this->databaseTool->loadFixtures([
            RecordFixtures::class,
        ]);

        $this->auth();

        $this->request(sprintf('%s?%s', self::URL, http_build_query([
            'date' => (new DateTimeImmutable())->format('c'),
        ])));

        /** @var array[] $response */
        $response = $this->getClientResponse();

        self::assertSame(count($response), 3);
        self::assertSame($response[1]['id'], '76ba9e7d-2616-4ee3-bbbc-fa21e0e17b3b');
    }
}
