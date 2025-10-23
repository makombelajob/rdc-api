<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RailwayStationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RailwayStationRepository::class)]
#[ApiResource()]
class RailwayStation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sceSem = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sceGeo = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $origine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $province = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $district = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $breakdown = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $store = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $atelier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file = null;

    #[ORM\ManyToOne(inversedBy: 'railwayStations')]
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
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

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(?string $province): static
    {
        $this->province = $province;
        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(?string $district): static
    {
        $this->district = $district;
        return $this;
    }

    public function isBreakdown(): ?bool
    {
        return $this->breakdown;
    }

    public function setBreakdown(?bool $breakdown): static
    {
        $this->breakdown = $breakdown;
        return $this;
    }

    public function getStore(): ?string
    {
        return $this->store;
    }

    public function setStore(?string $store): static
    {
        $this->store = $store;
        return $this;
    }

    public function getAtelier(): ?int
    {
        return $this->atelier;
    }

    public function setAtelier(?int $atelier): static
    {
        $this->atelier = $atelier;
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
