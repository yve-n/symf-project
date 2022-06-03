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
        $parent->setSlug($this->slugger->slug($parent->getName())->lower());
        $manager->persist($parent);

        $category = new Category();
        $category->setName('Pantalons Jeans')
        ->setSlug($this->slugger->slug($category->getName())->lower())
        ->setParent($parent);

        $manager->persist($category);
        $manager->flush();
    }
}
