<?php

namespace App\DataFixtures;

use App\Entity\OrderDetail;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderDetailFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($od=1; $od <= 11 ; $od++) { 
            $product = $this->getReference('product-' . rand(1,10));
            $order = $this->getReference('order-' . rand(1,10));
            $orderDetail = new OrderDetail();
            $orderDetail
            ->setPrice($faker->randomFloat(2,50,300))
            ->setQuantity($faker->numberBetween(3,10))
            ->setProduct($product)
            ->setOrder($order);

            $this->addReference('orderDetail-'. $od, $orderDetail); 
            $manager->persist($orderDetail);
        }
        $manager->flush();
    }
    public function getDependencies() : array
    {
        return [
            ProductFixtures::class,
            OrderFixtures::class
        ];
    }
}
