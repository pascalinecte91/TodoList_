<?php

namespace App\Tests\TestsEntities;


use App\Entity\User;
use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class UserEntityTest extends KernelTestCase
{
    private $user;
    private $task;

    public function setUp(): void
    {
        $this->user = new User();
        $this->task = new Task();
    }

    public function testId(): void
    {
        $this->user->setId(1);
        $this->assertSame(1, $this->user->getId());
    }

    public function testEmail(): void
    {
        $this->user->setEmail('pascaline@gmail.com');
        $this->assertSame('pascaline@gmail.com', $this->user->getEmail());
    }

    public function testName(): void
    {
        $this->user->setName('pascaline');
        $this->assertSame('pascaline', $this->user->getName());
    }

    public function testPassword(): void
    {
        $this->user->setPassword('pascale');
        $this->assertSame('pascale', $this->user->getPassword());
    }

    public function testRoles(): void
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->assertSame(['ROLE_USER'], $this->user->getRoles());
    }

    public function testTask(): void
    {

        $this->user->addTask($this->task);
        $this->assertSame(1, count($this->user->getTasks()));

        $this->user->removeTask($this->task);
        $this->assertSame(0, count( $this->user->getTasks()));
    }
}
