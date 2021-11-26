<?php

namespace App\Tests\TestsFunctionals;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskRepositoryTest extends KernelTestCase
{
   /**
    * @var \Doctrine\ORM\EntityManager
    */
    private $entityManager;


    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByTitle(): void
    {
            $task = $this->entityManager
            ->getRepository(Task::class)
            ->findOneBy([
                'title' => 'test modification de la tâche',
            ]);

            $this->assertSame('test modification de la tâche', $task->getTitle());
   
     
    }
    
    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}


