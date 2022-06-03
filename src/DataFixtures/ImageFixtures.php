<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Image;
use App\DataFixtures\ProductFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($img = 1; $img <=15 ; $img++){
            $image = new Image();
            $image->setName($faker->imageUrl(640,480));

            $image->setProduct(
                $this->getReference('product-'. rand(1,10))
            );
            $manager->persist($image);
            
        }

        $manager->flush();
    }
    /** de base les fixtures s'executent par ordre alphabétique
     * -implementation de DependentFixtureInterface
     * -ajout de la methode getDependencies() qui 
     * -permet de load le fixture des produits avant le fixture des categories
    */ 
    public function getDependencies() : array
    {
        return [
            ProductFixtures::class
        ];
    }
}
