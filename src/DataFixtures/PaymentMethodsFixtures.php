<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\PaymentMethods;

class PaymentMethodsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $methods = ['Debit card', 'Credit card', 'BLIK', 'Cash', 'Bank transfer', 'Check transfer', 'Apple pay'];

        foreach ($methods as $name) {
            $method = new PaymentMethods();
            $method->setName($name);

            $manager->persist($method);
        }

        $manager->flush();
    }
}
