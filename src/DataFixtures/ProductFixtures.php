<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $product = (new Product())
                ->setName('Product' . $i)
                ->setDescription('Example description of product no.' . $i)
                ->setPrice(mt_rand(10 * 100, 600 * 100) / 100);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
