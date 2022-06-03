<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $parent = new Category();
        $parent->setName('Hommes');
        $parent->setSlug('hommes');
        $manager->persist($parent);

        $category = new Category();
        $category->setName('Pantalons')->setSlug('pantalons')->setParent($parent);

        $manager->persist($category);
        $manager->flush();
    }
}
