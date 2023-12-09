<?php

namespace App\Infrastructure;

use ApiPlatform\Operation\PathSegmentNameGeneratorInterface;
use Symfony\Component\String\Inflector\EnglishInflector;

final class SingularPathSegmentNameGenerator implements PathSegmentNameGeneratorInterface
{
    public function getSegmentName(string $name, bool $collection = true): string
    {
        // Fix the plural of 'pokemon' being set to pokema
        if ('Pokemon' === $name) {
            return 'pokemons';
        }

        $snakeCaseName = mb_strtolower(preg_replace('~(?<=\\w)([A-Z])~u', '_$1', $name));

        return (new EnglishInflector())->pluralize($snakeCaseName)[0] ?? $snakeCaseName;
    }
}
