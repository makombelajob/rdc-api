<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PortRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortRepository::class)]
#[ApiResource()]
class Port
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sceSem = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sceGeo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $origine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $province = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $administrative = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeGrpt = null;

    #[ORM\ManyToOne(inversedBy: 'ports')]
    private ?Province $provinceEntity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSceSem(): ?string
    {
        return $this->sceSem;
    }

    public function setSceSem(?string $sceSem): static
    {
        $this->sceSem = $sceSem;
        return $this;
    }

    public function getSceGeo(): ?string
    {
        return $this->sceGeo;
    }

    public function setSceGeo(?string $sceGeo): static
    {
        $this->sceGeo = $sceGeo;
        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(?string $origine): static
    {
        $this->origine = $origine;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): static
    {
        $this->province = $province;
        return $this;
    }

    public function getAdministrative(): ?string
    {
        return $this->administrative;
    }

    public function setAdministrative(?string $administrative): static
    {
        $this->administrative = $administrative;
        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): static
    {
        $this->file = $file;
        return $this;
    }

    public function getCodeGrpt(): ?string
    {
        return $this->codeGrpt;
    }

    public function setCodeGrpt(?string $codeGrpt): static
    {
        $this->codeGrpt = $codeGrpt;
        return $this;
    }

    public function getProvinceEntity(): ?Province
    {
        return $this->provinceEntity;
    }

    public function setProvinceEntity(?Province $provinceEntity): static
    {
        $this->provinceEntity = $provinceEntity;
        return $this;
    }
}
