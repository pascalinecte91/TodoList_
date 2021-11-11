<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


class TaskFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');


        for ($i = 0; $i < 5; $i++) {
            $user = $this->getReference('user');
            $task = new Task();
            $task->setCreatedAt($faker->dateTimeInInterval('-1 week', '+4 days'))
                ->setTitle($faker->sentence(5))
                ->setCreatedBy($user)
                ->setContent($faker->paragraph(2, true))
                ->setIsDone($faker->boolean([rand(0, 1)]));

            $manager->persist($task);
        }

        for ($i = 0; $i < 3; $i++) {
            $task = new Task();
            $task->setCreatedAt($faker->dateTimeInInterval('-1 week', '+4 days'))
                ->setTitle($faker->sentence(5))
                ->setCreatedBy(null)
                ->setContent($faker->paragraph(2, true))
                ->setIsDone($faker->boolean([rand(0, 1)]));

            $manager->persist($task);
        }

        for ($i = 1; $i < 40; $i++) {
            $user = $this->getReference('user_' . $faker->numberBetween(1, 10));
            $task = new Task();
            $task->setCreatedAt($faker->dateTimeInInterval('-1 week', '+4 days'))
                ->setTitle($faker->sentence(5))
                ->setCreatedBy($user)
                ->setContent($faker->paragraph(2, true))
                ->setIsDone($faker->boolean([rand(0, 1)]));

            $manager->persist($task);
        }

        $manager->flush();
    }
    public function getOrder()
    {
        return 2;
    }
}
