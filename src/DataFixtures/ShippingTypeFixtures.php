<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ShippingType;

class ShippingTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $methods = [
            ['name' => 'DPD', 'price' => 19.99],
            ['name' => 'UPS', 'price' => 16.99],
            ['name' => 'Poczta Polska', 'price' => 10.00],
            ['name' => 'InPost', 'price' => 12.00],
            ['name' => 'DHL', 'price' => 15.00]
        ];


        foreach ($methods as $methodData) {
            $method = new ShippingType();
            $method->setType($methodData['name']);
            $method->setPrice($methodData['price']);

            $manager->persist($method);
        }

        $manager->flush();
    }
}
