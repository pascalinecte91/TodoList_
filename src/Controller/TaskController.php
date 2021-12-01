<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use App\Security\Voter\TaskVoter;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks/toggle", name="task_list")
     */
    public function listAction(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $taskRepository->findAllForCurrentUser(false)
        ]);
    }


    /**
     * @Route("/tasks/ending", name="task_list_ending")
     */
    public function listEndingAction(TaskRepository $taskRepository)
    {

        return $this->render('task/list.ending.html.twig', [
            'tasks' => $taskRepository->findAllForCurrentUser(true)
        ]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $task->setCreatedBy($this->getUser());
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche est crée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request, UserInterface $user)
    {
        $this->denyAccessUnlessGranted('task_edit', $task);
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Tâche correctement modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $this->denyAccessUnlessGranted('task_toggle', $task);
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        if ($task->isDone() == 1) {
            $this->addFlash('success', sprintf(
                'La tâche %s est bien notée comme finie',
                $task->getTitle()
            ));
        } else {
            $this->addFlash('success', sprintf(
                'La tâche %s a bien été marquée comme à finir',
                $task->getTitle()
            ));
        }
        return $this->redirectToRoute('task_list');
    }


    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task)
    {
        $this->denyAccessUnlessGranted('task_delete', $task);
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche est bien supprimée');

        return $this->redirectToRoute('task_list');
    }
}
