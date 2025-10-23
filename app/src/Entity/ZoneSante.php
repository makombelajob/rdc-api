<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ZoneSanteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZoneSanteRepository::class)]
#[ApiResource()]
class ZoneSante
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

    #[ORM\Column(length: 255)]
    private ?string $zoneDeSante = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $pcodeZs = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $pop2019 = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $pop2020 = null;

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

    public function getZoneDeSante(): ?string
    {
        return $this->zoneDeSante;
    }

    public function setZoneDeSante(string $zoneDeSante): static
    {
        $this->zoneDeSante = $zoneDeSante;

        return $this;
    }

    public function getPcodeZs(): ?string
    {
        return $this->pcodeZs;
    }

    public function setPcodeZs(?string $pcodeZs): static
    {
        $this->pcodeZs = $pcodeZs;

        return $this;
    }

    public function getPop2019(): ?string
    {
        return $this->pop2019;
    }

    public function setPop2019(?string $pop2019): static
    {
        $this->pop2019 = $pop2019;

        return $this;
    }

    public function getPop2020(): ?string
    {
        return $this->pop2020;
    }

    public function setPop2020(?string $pop2020): static
    {
        $this->pop2020 = $pop2020;

        return $this;
    }
}
