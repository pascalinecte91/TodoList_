<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $user = new User();
        $user->setEmail('pascaline@gmail.com')
        ->setPassword($this->encoder->encodePassword($user, 'pascale'))
        ->setUsername('pascaline')
        ->setRoles(['ROLE_ADMIN']);
    

    for ($u = 0; $u <= 15; $u++) {
        $user = new User();
        $user->setEmail($faker->email())
            ->setPassword($this->encoder->encodePassword($user, 'pascale'))
            ->setUsername($faker->lastName())
            ->setRoles(['ROLE_USER']);
        $manager->persist($user);
    }
        $manager->flush();
}
}
