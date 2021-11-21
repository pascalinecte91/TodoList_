<?php

namespace App\Tests\TestsFunctionals;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

class FormTaskTypeTest extends TypeTestCase
{
    public function testSubmitValidDataTaskType(): void
    {
        $formData = [
            'title'=> 'un nouveau titre',
            'content'=> 'le contenu'
        ];
        $modelformTask = new Task();
        // le model recupere les donnees
        $form = $this->factory->create(TaskType::class, $modelformTask);

            $task = new task();
            $task->setTitle($formData['title']);
            $task->setContent($formData['content']);

            $form->submit($formData);
            $this->assertTrue($form->isSynchronized());

            $this->assertEquals($task->getTitle(), $form->get('title')->getData());
            $this->assertEquals($task->getContent(), $form->get('content')->getData());
            //verifie la creation du form et les proprietes disponibles
            $view = $form->createView();
            $children = $view->children;
    
            foreach (array_keys($formData) as $key) {
                $this->assertArrayHasKey($key, $children);
            }
       
    }
}
