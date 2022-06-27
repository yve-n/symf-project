<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for($p=1; $p <=10 ; $p++){

            $product = new Product();
            $product
                ->setName($faker->text(20))
                ->setDescription($faker->text(200))
                ->setSlug($this->slugger->slug($product->getName())->lower())
                ->setPrice($faker->randomFloat(2,30,150))
                ->setQuantity($faker->numberBetween(3,10));

                if($p % 2 == 0)
                    $product->setSoldPrice($faker->randomFloat(2,20,29));
                
                //recuperer les references de nos categories
                $category = $this->getReference('category-' . rand(1,6));
                $product->setCategory($category);

                /**addReference permet d'ajouter une reference à chaque produit 
                 * et throw une exception si la reference existe déjà */

                $this->addReference('product-'. $p, $product); 
                
            $manager->persist($product);
        }

        $manager->flush();
    }
}
