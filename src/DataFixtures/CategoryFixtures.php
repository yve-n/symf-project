<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    public function __construct( private SluggerInterface $slugger){}

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
