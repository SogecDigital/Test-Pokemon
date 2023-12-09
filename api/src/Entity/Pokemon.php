<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Delete(),
        new Patch(),
    ],
    normalizationContext: ['groups' => [self::DENORMALIZATION, self::NORMALIZATION]],
    denormalizationContext: ['groups' => [self::DENORMALIZATION]],
    paginationClientItemsPerPage: true,
    paginationItemsPerPage: 50,
)]
class Pokemon
{
    public const DENORMALIZATION = 'pokemon_write';

    public const NORMALIZATION = 'pokemon_read';

    /** @var Collection<int, Type> */
    #[ORM\ManyToMany(targetEntity: Type::class, cascade: ['persist'])]
    #[Groups(Pokemon::NORMALIZATION)]
    #[ApiFilter(SearchFilter::class, properties: ['types.name'])]
    public Collection $types;

    public function __construct(
        #[ORM\Column]
        #[Groups(Pokemon::DENORMALIZATION)]
        #[ApiFilter(SearchFilter::class, strategy: 'ipartial')]
        #[Assert\NotBlank]
        public string $name,
        #[ORM\Column]
        #[Groups(Pokemon::DENORMALIZATION)]
        #[Assert\Positive]
        public int $hp,
        #[ORM\Column]
        #[Groups(Pokemon::DENORMALIZATION)]
        #[Assert\Positive]
        public int $attack,
        #[ORM\Column]
        #[Groups(Pokemon::DENORMALIZATION)]
        #[Assert\Positive]
        public int $defense,
        #[ORM\Column]
        #[Groups(Pokemon::DENORMALIZATION)]
        #[Assert\Positive]
        public int $sp_atk,
        #[ORM\Column]
        #[Groups(Pokemon::DENORMALIZATION)]
        #[Assert\Positive]
        public int $sp_def,
        #[ORM\Column]
        #[Groups(Pokemon::DENORMALIZATION)]
        #[Assert\Positive]
        public int $speed,
        #[ORM\Column(type: 'smallint')]
        #[Groups(Pokemon::DENORMALIZATION)]
        #[ApiFilter(NumericFilter::class)]
        #[Assert\Range(
            min: 1,
            max: 10,
        )]
        public int $generation,
        #[ORM\Column]
        #[Groups([Pokemon::DENORMALIZATION])]
        #[ApiFilter(BooleanFilter::class)]
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
