<?php

namespace App\Security;


use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        if ($user->getIsDeleted()) {
            throw new CustomUserMessageAuthenticationException("Access denied");
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof $user) {
            return;
        }

        if (!$user->getIsActive()) {
            throw new DisabledException();
        }
    }
}