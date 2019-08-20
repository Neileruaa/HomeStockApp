<?php


namespace App\Security;


use App\Entity\Famille;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class FamilleVoter extends Voter
{

    const HEAD_FAMILY = 'headFamily';
    const LEAVE = 'canLeave';

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::HEAD_FAMILY, self::LEAVE])){
            return false;
        }

        if (!$subject instanceof Famille){
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User){
            return false;
        }

        /** @var Famille $famille */
        $famille = $subject;

        switch ($attribute) {
            case self::HEAD_FAMILY:
                return $this->canUsePowerOfHeadFamily($famille, $user);
            case self::LEAVE:
                return $this->canLeave($famille, $user);
        }

        throw new \LogicException('Tu ne devrais pas lire ca mon bro');
    }

    private function canUsePowerOfHeadFamily(Famille $famille, User $user)
    {
        return $user === $famille->getHeadFamily();
    }

    private function canLeave(Famille $famille, User $user)
    {
        return $user !== $famille->getHeadFamily();
    }
}