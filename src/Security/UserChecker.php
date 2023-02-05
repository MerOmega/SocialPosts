<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\User as AppUser;
use DateTime;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{


    /**
     * @param User $user
     * @return void
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if ($user->getBannedUntil() === null) {
            return;
        }
        $currentDate = new DateTime();

        if ($currentDate < $user->getBannedUntil()) {
            // the message passed to this exception is meant to be displayed to the user
            throw new AccessDeniedHttpException('Your user account was Banned.');
        }
    }

    /**
     * @param User $user
     * @return void
     */
    public function checkPostAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // user account is expired, the user may be notified
//        if ($user->isExpired()) {
//            return;
//        }
    }
}