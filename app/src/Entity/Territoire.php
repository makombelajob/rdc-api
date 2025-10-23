<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TerritoireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerritoireRepository::class)]
#[ApiResource()]
class Territoire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $province = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $pcodeProvince = null;

    #[ORM\Column(length: 255)]
    private ?string $territoire = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $pcodeTerritoire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(string $province): static
    {
        $this->province = $province;

        return $this;
    }

    public function getPcodeProvince(): ?string
    {
        return $this->pcodeProvince;
    }

    public function setPcodeProvince(?string $pcodeProvince): static
    {
        $this->pcodeProvince = $pcodeProvince;

        return $this;
    }

    public function getTerritoire(): ?string
    {
        return $this->territoire;
    }

    public function setTerritoire(string $territoire): static
    {
        $this->territoire = $territoire;

        return $this;
    }

    public function getPcodeTerritoire(): ?string
    {
        return $this->pcodeTerritoire;
    }

    public function setPcodeTerritoire(?string $pcodeTerritoire): static
    {
        $this->pcodeTerritoire = $pcodeTerritoire;

        return $this;
    }
}
