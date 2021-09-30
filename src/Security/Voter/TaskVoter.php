<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TaskVoter extends Voter
{
    const TASK_EDIT = 'task_edit';
    const TASK_DELETE = 'task_delete';
    const TASK_TOGGLE = 'task_toggle';

    protected function supports(string $attribute, $task): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html

        // controle envi bonne info
        return in_array($attribute, [self::TASK_EDIT, self::TASK_DELETE, self::TASK_TOGGLE])
            && $task instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, $task, TokenInterface $token): bool
    {
        $user = $token->getUser(); // find user login
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        // si le task a un createdby
        if (null === $task->getCreatedBy()) return false;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::TASK_EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                return $this->canEdit($task, $user);
                break;

            case self::TASK_DELETE:
                // logic to determine if the user can DELETE
                // return true or false
                return $this->canDelete($task, $user);
                break;

            case self::TASK_TOGGLE:
                // logic to determine if the user can DELETE
                // return true or false
                return $this->canToggle($task, $user);
                break;
        }

        return false;
    }

    private function canEdit(Task $task, User $user)
    { 
        //creator can edit task
        return $user === $task->getCreatedBy();
    }

    private function canDelete(Task $task, User $user)
    {
              //creator can delete task
              return $user === $task->getCreatedBy();
    }

    private function canToggle(Task $task, User $user)
    {
              //creator can toggle task
              return $user === $task->getCreatedBy();
    }
}
