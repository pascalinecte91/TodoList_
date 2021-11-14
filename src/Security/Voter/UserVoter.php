<?php

namespace App\Security\Voter;


use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    const USER_EDIT = 'user_edit';
    const USER_DELETE = 'user_delete';
    const USER_CREATE = 'user_create';
    const USER_VIEW = 'user_view';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::USER_EDIT, self::USER_DELETE, self::USER_VIEW, self::USER_CREATE])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // pas d'acces si anonymous
        if (!$user instanceof UserInterface) {
            return false;
        }
           // Tout faire si role admin
           if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }
             // ROLE_USER peut modifier son compte à lui uniquement
        if (in_array($attribute, ['USER_EDIT', 'USER_DELETE'])) {
            return $user === $subject;
        }
        return false;
    }

}