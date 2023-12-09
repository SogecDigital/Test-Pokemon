<?php
// api/src/Security/Voter/BookVoter.php

namespace App\Security;

use App\Entity\Pokemon;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PokemonVoter extends Voter
{
    public const string EDIT = 'POKEMON_EDIT';
    public const string DELETE = 'POKEMON_DELETE';

    public function __construct(
    )
    {
    }

    protected function supports($attribute, $subject): bool
    {
        $supportsAttribute = in_array($attribute, [self::EDIT, self::DELETE]);
        $supportsSubject = $subject instanceof Pokemon;

        return $supportsAttribute && $supportsSubject;
    }

    /**
     * @param Pokemon $subject
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        return $token->getUser() !== null && !$subject->legendary;
    }
}
