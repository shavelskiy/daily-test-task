<?php

declare(strict_types=1);

namespace App\Tests\Controller\Record;

use App\DataFixtures\RecordFixtures;
use App\Tests\Controller\AbstractControllerTestCase;

class RecordFinishControllerTest extends AbstractControllerTestCase
{
    private const URL = '/v1/record/finish';

    public function testRecordFinish(): void
    {
        $this->databaseTool->loadFixtures([
            RecordFixtures::class,
        ]);

        $this->auth();

        $this->postRequest(sprintf('%s/%s', self::URL, '76ba9e7d-2616-4ee3-bbbc-fa21e0e17b3b'));

        self::assertResponseIsSuccessful();
    }
}
