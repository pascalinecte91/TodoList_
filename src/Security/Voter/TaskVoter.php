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
        // on verifie que l'utilisateur est bien admin
        if($this->security->isGranted('ROLE_ADMIN'))
        return true;

        // On verifie si la tache a un proprietaire
        if (null === $subject->getCreatedBy()) {
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
    private function canEdit(Task $task, User $user) {
        //le proprietaire peut modifier
        return $user === $task->getCreatedBy();
    }
    private function canToggle(Task $task, User $user) {
        //le proprietaire peut changer statut
        return $user === $task->getCreatedBy();
    }
    private function canDelete(Task $task, User $user) {
        //le proprietaire peut supprimer
        return $user === $task->getCreatedBy();
    }
}