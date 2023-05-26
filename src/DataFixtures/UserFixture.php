<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail(sprintf('webstore%d@example.com', $i));
            $user->setRoles(['ROLE_USER']);
            $user->setPlainPassword('password');
            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashedPassword);

            $user->setFirstName('Name' . $i);
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
