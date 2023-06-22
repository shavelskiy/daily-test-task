<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Record;
use App\Repository\FileRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Uid\Uuid;

class RecordFixtures extends Fixture implements DependentFixtureInterface
{
    private const DATA = [
        [
            'id' => 'ffddde5c-0f42-4a23-b0c1-c7b9776d060c',
            'user_id' => 'df7ff784-4c83-4b88-bd57-6063fb639763',
            'text' => 'Запись 1',
            'files' => [
                'c98c0105-fdba-4b31-a4ef-72d344ec66eb',
                '9d6c43a8-22ef-411c-968c-7e8641aed539',
            ],
            'done' => false,
        ],
        [
            'id' => '76ba9e7d-2616-4ee3-bbbc-fa21e0e17b3b',
            'user_id' => 'df7ff784-4c83-4b88-bd57-6063fb639763',
            'text' => 'Запись 2',
            'files' => [
                'ca594ded-46f5-4b71-8908-ec187a3c3ab5',
            ],
            'done' => false,
        ],
        [
            'id' => '3c019c0d-5447-475d-8ea6-fa6b1ffc2828',
            'user_id' => 'df7ff784-4c83-4b88-bd57-6063fb639763',
            'text' => 'Запись 3',
            'files' => [],
            'done' => false,
        ],
        [
            'id' => '03aaba97-4e0f-4549-9286-d60fb1f0da5d',
            'user_id' => 'df7ff784-4c83-4b88-bd57-6063fb639763',
            'text' => 'Запись 4',
            'files' => [],
            'done' => true,
            'yesterday' => true,
        ]
    ];

    private UserRepository $userRepository;
    private FileRepository $fileRepository;

    public function __construct(
        UserRepository $userRepository,
        FileRepository $fileRepository
    ) {
        $this->userRepository = $userRepository;
        $this->fileRepository = $fileRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $date = new DateTimeImmutable();

        foreach (self::DATA as $item) {
            $record = new Record(
                $this->userRepository->find($item['user_id']),
                isset($item['yesterday']) ? $date->modify('-1 day') : $date,
            );

            $record->setId(Uuid::fromString($item['id']));

            $record
                ->setText($item['text'])
                ->setDone($item['done']);

            foreach ($item['files'] as $file) {
                $record->addFile(
                    $this->fileRepository->find($file),
                );
            }

            $manager->persist($record);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            FileFixtures::class,
        ];
    }
}
