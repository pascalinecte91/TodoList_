<?php

namespace App\Tests;


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

    public function testUsername(): void
    {
        $this->user->setUsername('pascaline');
        $this->assertSame('pascaline', $this->user->getUsername());
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
        $task = $this->user->getTasks($this->task->getCreatedBy());
        $this->assertSame($this->user->getTasks(), $task);

        $this->user->addTask($this->task);
        $this->assertSame(1, $this->user->getTasks());

        $this->user->removeTask($this->task);
        $this->assertSame(0, $this->user->getTasks());
    }
}
