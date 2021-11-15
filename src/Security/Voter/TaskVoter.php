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
 

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html

        // controle envoi bonne info
        return in_array($attribute, [self::TASK_EDIT, self::TASK_DELETE, self::TASK_TOGGLE])
            && $subject instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, $task, TokenInterface $token): bool
    {
        $user = $token->getUser(); // find user login
    
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        // si le task n' a pas un createdby
        if (null === $task->getCreatedBy()) {
            return false;
        }
        if ($attribute == 'TASK_TOGGLE') {
            // user doit etre l'auteur de la tache  ou etre  ROLE ADMIN 
            return $user === $task->getCreatedBy() || in_array('ROLE_ADMIN', $user->getRoles());
        }
        if (in_array($attribute, ['TASK_EDIT', 'TASK_DELETE'])) {
            // le user doit etre le proprietaire de la tache  ou avoir le role admin 
            return ($user === $task->getCreatedBy()) || (in_array('ROLE_ADMIN', $user->getRoles()) && null === $task->getCreatedBy());
        }

        return $this->canIfOwner($task, $user);
    }

    private function canIfOwner(Task $task, User $user)
    {
       
        return $user === $task->getCreatedBy();
    }
}