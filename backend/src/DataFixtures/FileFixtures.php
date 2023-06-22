<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\File;
use App\Repository\UserRepository;
use App\Service\File\FileStorage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

class FileFixtures extends Fixture implements DependentFixtureInterface
{
    private const DATA = [
        [
            'id' => 'c98c0105-fdba-4b31-a4ef-72d344ec66eb',
            'user_id' => 'df7ff784-4c83-4b88-bd57-6063fb639763',
            'name' => 'file.pdf',
            'content_type' => 'application/pdf',
        ],
        [
            'id' => '9d6c43a8-22ef-411c-968c-7e8641aed539',
            'user_id' => 'df7ff784-4c83-4b88-bd57-6063fb639763',
            'name' => 'image.jpeg',
            'content_type' => 'image/jpeg',
        ],
        [
            'id' => 'ca594ded-46f5-4b71-8908-ec187a3c3ab5',
            'user_id' => 'df7ff784-4c83-4b88-bd57-6063fb639763',
            'name' => 'document.doc',
            'content_type' => 'application/msword',
        ],
    ];

    private UserRepository $userRepository;
    private FileStorage $fileStorage;

    public function __construct(
        UserRepository $userRepository,
        FileStorage $fileStorage
    ) {
        $this->userRepository = $userRepository;
        $this->fileStorage = $fileStorage;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $item) {
            $file = new File($this->userRepository->find($item['user_id']));
            $file->setId(Uuid::fromString($item['id']));
            $file
                ->setName($item['name'])
                ->setContentType($item['content_type'])
            ;

            $this->fileStorage->save(
                $file,
                new UploadedFile(__DIR__ . '/../../tests/fixtures/' . $item['name'], $item['name']),
            );

            $manager->persist($file);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
