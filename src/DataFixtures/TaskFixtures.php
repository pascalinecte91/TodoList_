<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        
    for ($i = 1; $i <= 30; $i++) {
        $task = new Task();  
        $task->setCreatedAt($faker->dateTimeInInterval('-1 week', '+4 days'))
            ->setTitle($faker->sentence())
            ->setContent($faker->paragraph(2, true))
            ->setIsDone($faker->boolean([rand(0, 1)]));

        $manager->persist($task);
    }

        $manager->flush();
    }
}
