<?php

namespace App\Entity;

use App\Repository\PokemonTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonTypeRepository::class)]
class PokemonType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'type1', targetEntity: Pokemon::class)]
    private $type2;

    #[ORM\OneToMany(mappedBy: 'type2', targetEntity: Pokemon::class)]
    private $pokemon;

    public function __construct()
    {
        $this->type2 = new ArrayCollection();
        $this->pokemon = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Pokemon>
     */
    public function getType2(): Collection
    {
        return $this->type2;
    }

    public function addType2(Pokemon $type2): self
    {
        if (!$this->type2->contains($type2)) {
            $this->type2[] = $type2;
            $type2->setType1($this);
        }

        return $this;
    }

    public function removeType2(Pokemon $type2): self
    {
        if ($this->type2->removeElement($type2)) {
            // set the owning side to null (unless already changed)
            if ($type2->getType1() === $this) {
                $type2->setType1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pokemon>
     */
    public function getPokemon(): Collection
    {
        return $this->pokemon;
    }

    public function addPokemon(Pokemon $pokemon): self
    {
        if (!$this->pokemon->contains($pokemon)) {
            $this->pokemon[] = $pokemon;
            $pokemon->setType2($this);
        }

        return $this;
    }

    public function removePokemon(Pokemon $pokemon): self
    {
        if ($this->pokemon->removeElement($pokemon)) {
            // set the owning side to null (unless already changed)
            if ($pokemon->getType2() === $this) {
                $pokemon->setType2(null);
            }
        }

        return $this;
    }
}
