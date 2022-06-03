<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder){
    }
    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin
        ->setEmail('admin@m2i.com')
        ->setLastName('Doe')
        ->setFirstName('john')
        ->setAddress('12 rue picpus')
        ->setCity('Paris')
        ->setZipCode('75012')
        ->setCountry('France')
        ->setPassword($this->passwordEncoder->hashPassword($admin, 'admin'))
        ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        $manager->flush();
    }
}
