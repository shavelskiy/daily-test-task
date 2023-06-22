<?php

declare(strict_types=1);

namespace App\Tests\Controller\Record;

use App\DataFixtures\RecordFixtures;
use App\Tests\Controller\AbstractControllerTestCase;

class RecordDeleteControllerTest extends AbstractControllerTestCase
{
    private const URL = '/v1/record';

    public function testRecordDelete(): void
    {
        $this->databaseTool->loadFixtures([
            RecordFixtures::class,
        ]);

        $this->auth();

        $this->deleteRequest(sprintf('%s/%s', self::URL, '76ba9e7d-2616-4ee3-bbbc-fa21e0e17b3b'));

        self::assertResponseIsSuccessful();
    }
}
