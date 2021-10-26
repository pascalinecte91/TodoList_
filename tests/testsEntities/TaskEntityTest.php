<?php

namespace App\Tests\TestsEntities;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskEntityTest extends KernelTestCase
{
        private $task;
        private $createdAt;
    
        public function setUp(): void
        {
            $this->task = new Task();
            $this->createdAt = new \DateTime();
      
        }
    
        public function testId(): void
        {
            $this->task->setId(1);
            $this->assertSame(1, $this->task->getId(),'test_id');
        }
    
    
        public function testCreatedAt(): void
        {
            $this->task->setCreatedAt($this->createdAt);
            $this->assertSame($this->createdAt, $this->task->getCreatedAt(),'test_created_at');
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
