<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ApiResource(operations: [new GetCollection()])]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    public function __construct(
        #[ORM\Column(length: 255, unique: true)]
        public string $name
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
