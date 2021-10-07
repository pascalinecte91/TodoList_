<?php

namespace App\Tests;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskEntityTest extends KernelTestCase
{
        private $task;
        private $created_At;
    
        public function setUp(): void
        {
            $this->task = new Task();
            $this->created_At = new \DateTime();
      
        }
    
        public function testId(): void
        {
            $this->task->setId(1);
            $this->assertSame(1, $this->task->getId(),'test_id');
        }
    
    
        public function testCreated_At(): void
        {
            $this->task->setCreatedAt($this->created_At);
            $this->assertSame($this->created_At, $this->task->getCreatedAt(),'test_created_at');
        }
    
        public function testTitle(): void
        {
            $this->task->setTitle('test_title');
            $this->assertSame($this->task->getTitle(), 'test_title');
        }
    
        public function testContent(): void
        {
            $this->task->setContent('test_content');
            $this->assertSame ($this->task->getContent(), 'test_content');
        }
        
        public function testIsDone(): void
        {
            $this->task->toggle(true);
            $this->assertEquals($this->task->getIsDone(), true);
            
        }
    
}