<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = (new User())
                ->setEmail(sprintf('webstore%d@example.com', $i))
                ->setRoles(['main_users'])
                ->setPassword('password')
                ->setFirstName('Name' . $i);
            $manager->persist($user);
        }
        // $this->createMany(10, 'main_users', function ($i) {
        //     $user = new User();
        //     $user->setEmail(sprintf('webstore%d@example.com', $i));
        //     $user->setFirstName($this->faker->firstName);

        //     return $user;

        $manager->flush();
    }
}
