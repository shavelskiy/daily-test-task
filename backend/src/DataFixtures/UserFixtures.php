<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class UserFixtures extends Fixture
{
    private const DATA = [
        [
            'id' => 'd1b5b149-83c6-479d-b28d-7b0290f97ff5',
            'email' => 'admin@admin.admin',
            'password' => 'admin',
            'admin' => true,
            'active' => true,
        ],
        [
            'id' => 'df7ff784-4c83-4b88-bd57-6063fb639763',
            'email' => 'user@user.user',
            'password' => 'user',
            'admin' => false,
            'active' => true,
        ],
        [
            'id' => '4687c4b6-2e37-4bf8-8b51-34f237e12b53',
            'email' => 'block-user@user.user',
            'password' => 'block',
            'admin' => false,
            'active' => false,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::DATA as $item) {
            $user = new User();
            $user->setId(Uuid::fromString($item['id']));
            $user
                ->setEmail($item['email'])
                ->setPassword(sha1('daily-salt' . $item['password']))
                ->setAdmin($item['admin'])
                ->setActive($item['active'])
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
