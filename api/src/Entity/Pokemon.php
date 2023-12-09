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


#[ORM\Entity]
#[ApiResource(
    shortName: 'Pokemon',
    operations: [
        new Get(),
        new GetCollection(),
        new Delete(),
        new Patch(),
    ],
)]
class Pokemon
{
    /** @var Collection<int, Type> */
    #[ORM\ManyToMany(targetEntity: Type::class, cascade: ['persist'])]
    public Collection $types;

    public function __construct(
        #[ORM\Column]
        public string   $name,

        #[ORM\Column]
        public int      $hp,

        #[ORM\Column]
        public int      $attack,

        #[ORM\Column]
        public int      $defense,

        #[ORM\Column]
        public int      $sp_atk,

        #[ORM\Column]
        public int      $sp_def,

        #[ORM\Column]
        public int      $speed,

        #[ORM\Column(type: 'smallint')]
        public int      $generation,

        #[ORM\Column]
        public bool     $legendary,

        #[ORM\Column]
        public int  $total = 0,

        #[ORM\Id]
        #[ORM\Column]
        public readonly ?int $id = null,

        Collection|array $types = new ArrayCollection(),
    )
    {
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
