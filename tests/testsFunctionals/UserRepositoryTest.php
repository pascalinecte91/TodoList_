<?php

namespace App\Tests\TestsFunctionals;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
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

    public function testSearchByName(): void
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy([
                'name' => 'pascaline',
            ]);

        $this->assertSame('pascaline', $user->getName());
        $this->assertSame('pascaline@gmail.com', $user->getEmail());
       
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // eviter que la memoire ne soit encombrée
        $this->entityManager->close();
        $this->entityManager = null;
    }

}
