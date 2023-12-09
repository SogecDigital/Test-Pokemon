<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Delete(),
        new Patch(),
    ],
    normalizationContext: ['groups' => [self::NORMALIZATION]],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 50,
)]
class Pokemon
{
    public const NORMALIZATION = 'pokemon_read';

    /** @var Collection<int, Type> */
    #[ORM\ManyToMany(targetEntity: Type::class, cascade: ['persist'])]
    #[Groups(Pokemon::NORMALIZATION)]
    public Collection $types;

    public function __construct(
        #[ORM\Column]
        #[Groups(Pokemon::NORMALIZATION)]
        public string $name,
        #[ORM\Column]
        #[Groups(Pokemon::NORMALIZATION)]
        public int $hp,
        #[ORM\Column]
        #[Groups(Pokemon::NORMALIZATION)]
        public int $attack,
        #[ORM\Column]
        #[Groups(Pokemon::NORMALIZATION)]
        public int $defense,
        #[ORM\Column]
        #[Groups(Pokemon::NORMALIZATION)]
        public int $sp_atk,
        #[ORM\Column]
        #[Groups(Pokemon::NORMALIZATION)]
        public int $sp_def,
        #[ORM\Column]
        #[Groups(Pokemon::NORMALIZATION)]
        public int $speed,
        #[ORM\Column(type: 'smallint')]
        #[Groups(Pokemon::NORMALIZATION)]
        public int $generation,
        #[ORM\Column]
        #[Groups(Pokemon::NORMALIZATION)]
        public bool $legendary,
        #[ORM\Column]
        public int $total = 0,
        #[ORM\Id]
        #[ORM\Column]
        #[Groups(Pokemon::NORMALIZATION)]
        public readonly ?int $id = null,
        Collection|array $types = new ArrayCollection(),
    ) {
        $this->types = $types instanceof Collection ? $types : new ArrayCollection($types);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function addType(Type $type): static
    {
        if (!$this->types->contains($type)) {
            $this->types->add($type);
        }

        return $this;
    }

    public function removeType(Type $type): static
    {
        $this->types->removeElement($type);

        return $this;
    }
}
