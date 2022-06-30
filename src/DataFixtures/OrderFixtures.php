<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Order;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($o=1; $o <= 10 ; $o++) { 
            $user = $this->getReference('user-' . rand(1,10));
            $order = new Order();
            $order
            ->setReference($faker->text(20))
            ->setUser($user); 

            $this->addReference('order-'. $o, $order); 
            $manager->persist($order);
        }
        $manager->flush();
    }
    public function getDependencies() : array
    {
        return [
            UserFixtures::class
        ];
    }
}
