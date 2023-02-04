<?php

namespace App\Security\Voter;

use App\Entity\MicroPost;
use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class MicroPostVoter extends Voter
{

    public function __construct(
        private AuthorizationCheckerInterface $security
    )
    {

    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [MicroPost::EDIT, MicroPost::VIEW])
            && $subject instanceof \App\Entity\MicroPost;
    }

    /*
     * @param MicroPost $subject
     * */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /* @var User $user */
        $user = $token->getUser();
        $isAuth = $user instanceof UserInterface;

        if($this->security->isGranted("ROLE_ADMIN")){
            return true;
        }

        // ... (check conditions and return true to grant permission) ...
        return match ($attribute) {
            MicroPost::EDIT => $isAuth && ($subject->getAuthor()->getId() === $user->getId())
                || $this->security->isGranted("ROLE_EDITOR"),
            MicroPost::VIEW => false,
            default => false,
        };

    }
}
