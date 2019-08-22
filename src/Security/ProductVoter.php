<?php


namespace App\Security;


use App\Entity\Famille;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProductVoter extends Voter
{

    const ADD_PRODUCT = 'addProduct';

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
        if (!in_array($attribute, [self::ADD_PRODUCT])){
            return false;
        }

        if (!$subject instanceof User){
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

        /** @var User $connectedUser */
        $connectedUser = $subject;

        switch ($attribute) {
            case self::ADD_PRODUCT:
                return $this->canAddProduct($user);
        }

        throw new \LogicException('Tu ne devrais pas lire ca mon bro');
    }

    private function canAddProduct(User $user)
    {
        return $user->getFamille() ? true : false;
    }
}