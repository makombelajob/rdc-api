<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProvinceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProvinceRepository::class)]
#[ApiResource()]
class Province
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $principalTown = null;

    #[ORM\Column(length: 255)]
    private ?string $surface = null;

    #[ORM\Column(length: 255)]
    private ?string $population = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 8, nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(type: 'decimal', precision: 11, scale: 8, nullable: true)]
    private ?float $longitude = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $pcodeProvince = null;

    #[ORM\OneToMany(mappedBy: 'province', targetEntity: City::class, cascade: ['persist'])]
    private Collection $cities;

    #[ORM\OneToMany(mappedBy: 'province', targetEntity: Airport::class, cascade: ['persist'])]
    private Collection $airports;

    #[ORM\OneToMany(mappedBy: 'province', targetEntity: Port::class, cascade: ['persist'])]
    private Collection $ports;

    #[ORM\OneToMany(mappedBy: 'province', targetEntity: RailwayStation::class, cascade: ['persist'])]
    private Collection $railwayStations;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
        $this->airports = new ArrayCollection();
        $this->ports = new ArrayCollection();
        $this->railwayStations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getPrincipalTown(): ?string
    {
        return $this->principalTown;
    }

    public function setPrincipalTown(string $principalTown): static
    {
        $this->principalTown = $principalTown;
        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): static
    {
        $this->surface = $surface;
        return $this;
    }

    public function getPopulation(): ?string
    {
        return $this->population;
    }

    public function setPopulation(string $population): static
    {
        $this->population = $population;
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

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): static
    {
        $this->longitude = $longitude;
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

    /**
     * @return Collection<int, City>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): static
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setProvince($this);
        }
        return $this;
    }

    public function removeCity(City $city): static
    {
        if ($this->cities->removeElement($city)) {
            if ($city->getProvince() === $this) {
                $city->setProvince(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Airport>
     */
    public function getAirports(): Collection
    {
        return $this->airports;
    }

    public function addAirport(Airport $airport): static
    {
        if (!$this->airports->contains($airport)) {
            $this->airports->add($airport);
            $airport->setProvince($this);
        }
        return $this;
    }

    public function removeAirport(Airport $airport): static
    {
        if ($this->airports->removeElement($airport)) {
            if ($airport->getProvince() === $this) {
                $airport->setProvince(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Port>
     */
    public function getPorts(): Collection
    {
        return $this->ports;
    }

    public function addPort(Port $port): static
    {
        if (!$this->ports->contains($port)) {
            $this->ports->add($port);
            $port->setProvince($this);
        }
        return $this;
    }

    public function removePort(Port $port): static
    {
        if ($this->ports->removeElement($port)) {
            if ($port->getProvince() === $this) {
                $port->setProvince(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, RailwayStation>
     */
    public function getRailwayStations(): Collection
    {
        return $this->railwayStations;
    }

    public function addRailwayStation(RailwayStation $railwayStation): static
    {
        if (!$this->railwayStations->contains($railwayStation)) {
            $this->railwayStations->add($railwayStation);
            $railwayStation->setProvince($this);
        }
        return $this;
    }

    public function removeRailwayStation(RailwayStation $railwayStation): static
    {
        if ($this->railwayStations->removeElement($railwayStation)) {
            if ($railwayStation->getProvince() === $this) {
                $railwayStation->setProvince(null);
            }
        }
        return $this;
    }
}
