<?php

namespace App\Security\Voter;

use Attribute;
use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TaskVoter extends Voter
{
    const TASK_EDIT = 'task_edit';
    const TASK_DELETE = 'task_delete';
    const TASK_TOGGLE = 'task_toggle';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {

        // controle envoi bonne info
        return in_array($attribute, [self::TASK_EDIT, self::TASK_DELETE, self::TASK_TOGGLE])
            && $subject instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser(); // find user login

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::TASK_EDIT:
                //verifie si on peut  modifier
                return $this->canEdit($subject, $user);
                break;
            case self::TASK_TOGGLE:
                //verifie si on peut changer le statut
                return $this->canToggle($subject, $user);
                break;
            case self::TASK_DELETE:
                //verifie si on peut supprimer
                return $this->canDelete($subject, $user);
                break;
        }

        return false;
    }

    private function canEdit(Task $task, User $user)
    {
        // 1) L'utilisateur a les droits Admin
        if ($this->security->isGranted('ROLE_ADMIN') === true) {
            return true;
        }

        // 2) Si l'utilisateur n'a pas les droits Admin : un booléen true si l'utilisateur est le propriétaire ou false s'il ne l'est pas.
        return $user === $task->getCreatedBy();
    }

    private function canToggle(Task $task, User $user)
    {
        // 1) L'utilisateur a les droits Admin, il peut éditer
        if ($this->security->isGranted('ROLE_ADMIN') === true) {
            return true;
        }

        // 2) Si l'utilisateur n'a pas les droits Admin, alors return un booléen true si l'utilisateur est le propriétaire ou false s'il ne l'est pas.
        return $user === $task->getCreatedBy();
    }

    private function canDelete(Task $task,User $user) {

        // 1) check si l'utilisateur a le ROLE_ADMIN  et on  check  si la task a été créée par un anonyme. Si true, return true, 

        if (
            $this->security->isGranted('ROLE_ADMIN') === true
            && $task->getCreatedBy() === null) {
            return true;
        }


        //  2) Si le if dessus n'est pas vrai, alors return un true si l'utilisateur est le propriétaire, false sinon.

        return $user === $task->getCreatedBy();
    }
}
