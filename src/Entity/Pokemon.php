<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/** A pokemon's Type. */
#[ORM\Entity(repositoryClass: PokemonRepository::class)]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get']
)]

class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\Column(type: 'integer')]
    private ?int $total;

    #[ORM\Column(type: 'integer')]
    private ?int $HP;

    #[ORM\Column(type: 'integer')]
    private ?int $attack;

    #[ORM\Column(type: 'integer')]
    private ?int $defense;

    #[ORM\Column(type: 'integer')]
    private ?int $spAtk;

    #[ORM\Column(type: 'integer')]
    private ?int $spDef;

    #[ORM\Column(type: 'integer')]
    private ?int $speed;

    #[ORM\Column(type: 'integer')]
    private ?int $generation;

    #[ORM\Column(type: 'boolean')]
    private $legendary;

    #[ORM\Column(type: 'integer')]
    private ?int $gameId;

    #[ORM\ManyToOne(targetEntity: PokemonType::class)]
    private ?PokemonType $type1;

    #[ORM\ManyToOne(targetEntity: PokemonType::class)]
    private ?PokemonType $type2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getHP(): ?int
    {
        return $this->HP;
    }

    public function setHP(int $HP): self
    {
        $this->HP = $HP;

        return $this;
    }

    public function getAttack(): ?int
    {
        return $this->attack;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): self
    {
        $this->defense = $defense;

        return $this;
    }

    public function getSpAtk(): ?int
    {
        return $this->spAtk;
    }

    public function setSpAtk(int $spAtk): self
    {
        $this->spAtk = $spAtk;

        return $this;
    }

    public function getSpDef(): ?int
    {
        return $this->spDef;
    }

    public function setSpDef(int $spDef): self
    {
        $this->spDef = $spDef;

        return $this;
    }

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getGeneration(): ?int
    {
        return $this->generation;
    }

    public function setGeneration(int $generation): self
    {
        $this->generation = $generation;

        return $this;
    }

    public function isLegendary(): ?bool
    {
        return $this->legendary;
    }

    public function setLegendary(bool $legendary): self
    {
        $this->legendary = $legendary;

        return $this;
    }

    public function getGameId(): ?int
    {
        return $this->gameId;
    }

    public function setGameId(int $gameId): self
    {
        $this->gameId = $gameId;

        return $this;
    }

    public function getType1(): ?PokemonType
    {
        return $this->type1;
    }

    public function setType1(?PokemonType $type1): self
    {
        $this->type1 = $type1;

        return $this;
    }

    public function getType2(): ?PokemonType
    {
        return $this->type2;
    }

    public function setType2(?PokemonType $type2): self
    {
        $this->type2 = $type2;

        return $this;
    }
}
