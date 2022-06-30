<?php

namespace App\DataFixtures;

use Faker\Factory;
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
        //$faker = Factory::create('fr_FR'); dis à faker de generer des data en français
        $faker = Factory::create('fr_FR');
        for($u=1; $u <=10; $u++){
            $user = new User();
            $user
            ->setEmail($faker->email)
            ->setLastName($faker->lastName)
            ->setFirstName($faker->firstName)
            ->setAddress($faker->streetAddress)
            ->setCity($faker->city)
            ->setZipCode(str_replace(" ","",$faker->postcode))
            ->setCountry('France')
            ->setPassword($this->passwordEncoder->hashPassword($admin, 'password')) ;  
            
            $this->addReference('user-'. $u, $user); 
            //dump($user) equivaut à console.log($user);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
