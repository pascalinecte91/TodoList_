<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    const USER_EDIT = 'user_edit';
    const USER_DELETE = 'user_delete';

    protected function supports(string $attribute, $user): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::USER_EDIT, self::USER_DELETE])
            && $user instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $user, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        if(['ROLE_ADMIN', $user->getRoles()]) return false;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::USER_EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                return $this->canEditUser($user);
                break;

            case 'USER_DELETE':
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canDeleteUser($user);
                break;
        }

        return false;
    }
    private function canEditUser(User $user)
    { 
        return $user === $user->getRoles();
    }

    private function canDeleteUser(User $user)
    {
              //creator can delete user
              return $user === $user->getRoles();
    }
}
