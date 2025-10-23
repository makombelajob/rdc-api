<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AirportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirportRepository::class)]
#[ApiResource()]
class Airport
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
    private ?string $namePrimary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameSecondary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $covering = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $airportUsage = null;

    #[ORM\Column(type: 'decimal', precision: 11, scale: 8, nullable: true)]
    private ?float $longitude = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 8, nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $length = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $width = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $altitude = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $practicable = null;

    #[ORM\ManyToOne(inversedBy: 'airports')]
    private ?Province $province = null;

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

    public function getNamePrimary(): ?string
    {
        return $this->namePrimary;
    }

    public function setNamePrimary(?string $namePrimary): static
    {
        $this->namePrimary = $namePrimary;
        return $this;
    }

    public function getNameSecondary(): ?string
    {
        return $this->nameSecondary;
    }

    public function setNameSecondary(?string $nameSecondary): static
    {
        $this->nameSecondary = $nameSecondary;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function getCovering(): ?string
    {
        return $this->covering;
    }

    public function setCovering(?string $covering): static
    {
        $this->covering = $covering;
        return $this;
    }

    public function getAirportUsage(): ?string
    {
        return $this->airportUsage;
    }

    public function setAirportUsage(?string $airportUsage): static
    {
        $this->airportUsage = $airportUsage;
        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): static
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): static
    {
        $this->length = $length;
        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): static
    {
        $this->width = $width;
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

    public function getAltitude(): ?int
    {
        return $this->altitude;
    }

    public function setAltitude(?int $altitude): static
    {
        $this->altitude = $altitude;
        return $this;
    }

    public function getPracticable(): ?string
    {
        return $this->practicable;
    }

    public function setPracticable(?string $practicable): static
    {
        $this->practicable = $practicable;
        return $this;
    }

    public function getProvince(): ?Province
    {
        return $this->province;
    }

    public function setProvince(?Province $province): static
    {
        $this->province = $province;
        return $this;
    }
}
