<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\TypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[ApiResource(operations: [new GetCollection()])]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[ORM\Column(length: 255, unique: true)]
        #[Groups(Pokemon::DENORMALIZATION)]
        public string $name
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
