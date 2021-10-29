<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $user = new User();
        $user->setEmail('pascaline@gmail.com')
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'pascale'))
            ->setName('pascaline')
            ->setRoles(['ROLE_ADMIN']);
            
            $manager->persist($user);

            $user = new User();
            $user->setEmail('user@gmail.com')
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'pascale'))
            ->setName('user')
            ->setRoles(['ROLE_USER']);
            
            $manager->persist($user);


        for ($u = 0; $u < 15; $u++) {
            $user = new User();
            $user->setEmail($faker->email())
                ->setPassword($this->userPasswordHasher->hashPassword($user, 'pascale'))
                ->setName($faker->lastName())
                ->setRoles(['ROLE_USER']);
                
            $manager->persist($user);
            
            $this->addReference('user_' . $u, $user);
        }
        $manager->flush();
    }
    public function getOrder()
    {
        return 1;
    }
}
