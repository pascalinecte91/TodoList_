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

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser(); // find user login

        // si le user est anomyme :  pas acces
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($attribute == 'TASK_TOGGLE') {
            // user doit etre l'auteur de la tache  ou etre  ROLE ADMIN 
            return $user === $subject->getCreatedBy() || in_array('ROLE_ADMIN', $user->getRoles());
        }
        if (in_array($attribute, ['TASK_EDIT', 'TASK_DELETE', 'TASK_VIEW'])) {
            // le user doit etre le proprietaire de la tache  ou avoir le role admin 
            return ($user === $subject->getCreatedBy()) || (in_array('ROLE_ADMIN', $user->getRoles()) && null === $subject->getCreatedBy());
        }

        return false;
    }
}
