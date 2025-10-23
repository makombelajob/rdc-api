<?php

namespace App\DataFixtures;

use App\Entity\Province;
use App\Entity\City;
use App\Entity\Airport;
use App\Entity\Port;
use App\Entity\RailwayStation;
use App\Entity\Administrative;
use App\Entity\Territoire;
use App\Entity\ZoneSante;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class CongoDataFixtures extends Fixture
{
    private string $dataPath;

    public function __construct()
    {
        $this->dataPath = __DIR__ . '/../../public/cd-data/src/';
        
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadProvinces($manager);
        $manager->flush(); // Persister les provinces d'abord
        
        $this->loadCities($manager);
        $this->loadAirports($manager);
        $this->loadPorts($manager);
        $this->loadRailwayStations($manager);
        $this->loadAdministratives($manager);
        $this->loadTerritoires($manager);
        $this->loadZoneSantes($manager);
        
        $manager->flush();
    }

    private function loadProvinces(ObjectManager $manager): void
    {
        $provincesData = json_decode(file_get_contents($this->dataPath . 'provinces.json'), true);
        $pcodeData = json_decode(file_get_contents($this->dataPath . 'pcode_province.json'), true);
        
        // Créer un mapping des codes provinces
        $pcodeMapping = [];
        if ($pcodeData && isset($pcodeData['pcode_province'])) {
            foreach ($pcodeData['pcode_province'] as $pcode) {
                $pcodeMapping[$pcode['Province']] = $pcode['pcode_province'];
            }
        }

        foreach ($provincesData as $provinceData) {
            $province = new Province();
            $province->setName($provinceData['name']);
            $province->setPrincipalTown($provinceData['principalTown']);
            $province->setSurface($provinceData['surface']);
            $province->setPopulation($provinceData['population']);
            
            if (isset($provinceData['latlng'])) {
                $province->setLatitude($provinceData['latlng']['lat']);
                $province->setLongitude($provinceData['latlng']['lng']);
            }
            
            // Ajouter le code province si disponible
            if (isset($pcodeMapping[$provinceData['name']])) {
                $province->setPcodeProvince($pcodeMapping[$provinceData['name']]);
            }
            
            $manager->persist($province);
        }
    }

    private function loadCities(ObjectManager $manager): void
    {
        $citiesData = json_decode(file_get_contents($this->dataPath . 'cities.json'), true);
        
        // Récupérer toutes les provinces pour le mapping
        $provinces = $manager->getRepository(Province::class)->findAll();
        $provinceMapping = [];
        foreach ($provinces as $province) {
            $provinceMapping[$province->getId()] = $province;
        }

        // Mapping des IDs de provinces depuis le JSON vers les noms
        $provinceIdToName = [
            1 => 'Bas-Uele',
            2 => 'Équateur', 
            3 => 'Haut-Katanga',
            4 => 'Haut-Lomami',
            5 => 'Haut-Uele',
            6 => 'Ituri',
            7 => 'Kasaï',
            8 => 'Kasaï-Central',
            9 => 'Kasaï-Oriental',
            10 => 'Kinshasa',
            11 => 'Kongo-Central',
            12 => 'Kwango',
            13 => 'Kwilu',
            14 => 'Lomami',
            15 => 'Lualaba',
            16 => 'Mai-Ndombe',
            17 => 'Maniema',
            18 => 'Mongala',
            19 => 'Nord-Kivu',
            20 => 'Nord-Ubangi',
            21 => 'Sankuru',
            22 => 'Sud-Kivu',
            23 => 'Sud-Ubangi',
            24 => 'Tanganyika',
            25 => 'Tshopo',
            26 => 'Tshuapa'
        ];

        foreach ($citiesData as $cityData) {
            $city = new City();
            $city->setName($cityData['name']);
            
            // Trouver la province par nom au lieu d'ID
            if (isset($provinceIdToName[$cityData['province_id']])) {
                $provinceName = $provinceIdToName[$cityData['province_id']];
                foreach ($provinces as $province) {
                    if ($province->getName() === $provinceName) {
                        $city->setProvince($province);
                        break;
                    }
                }
            }
            
            $manager->persist($city);
        }
    }

    private function loadAirports(ObjectManager $manager): void
    {
        $airportsData = json_decode(file_get_contents($this->dataPath . 'airports.json'), true);
        
        // Récupérer toutes les provinces pour le mapping
        $provinces = $manager->getRepository(Province::class)->findAll();
        $provinceMapping = [];
        foreach ($provinces as $province) {
            $provinceMapping[$province->getName()] = $province;
        }

        foreach ($airportsData['airports'] as $airportData) {
            $airport = new Airport();
            $airport->setSceSem($airportData['sce_sem'] ?? null);
            $airport->setSceGeo($airportData['sce_geo'] ?? null);
            $airport->setOrigine($airportData['origine'] ?? null);
            $airport->setNamePrimary($airportData['name_primary'] ?? null);
            $airport->setNameSecondary($airportData['name_secondary'] ?? null);
            $airport->setCategory($airportData['category'] ?? null);
            $airport->setCovering($airportData['covering'] ?? null);
            $airport->setAirportUsage($airportData['usage'] ?? null);
            $airport->setFile($airportData['file'] ?? null);
            $airport->setPracticable($airportData['practicable'] ?? null);
            
            // Conversion des coordonnées
            if (!empty($airportData['lat'])) {
                $airport->setLatitude((float) $airportData['lat']);
            }
            if (!empty($airportData['lng'])) {
                $airport->setLongitude((float) $airportData['lng']);
            }
            
            // Conversion des dimensions
            if (!empty($airportData['length'])) {
                $airport->setLength((int) $airportData['length']);
            }
            if (!empty($airportData['width'])) {
                $airport->setWidth((int) $airportData['width']);
            }
            if (!empty($airportData['altitude'])) {
                $airport->setAltitude((int) $airportData['altitude']);
            }
            
            // Conversion de la date
            if (!empty($airportData['updatedAt'])) {
                $airport->setUpdatedAt(new \DateTime($airportData['updatedAt']));
            }
            
            $manager->persist($airport);
        }
    }

    private function loadPorts(ObjectManager $manager): void
    {
        $portsData = json_decode(file_get_contents($this->dataPath . 'ports.json'), true);
        
        // Récupérer toutes les provinces pour le mapping
        $provinces = $manager->getRepository(Province::class)->findAll();
        $provinceMapping = [];
        foreach ($provinces as $province) {
            $provinceMapping[$province->getName()] = $province;
        }

        foreach ($portsData['ports'] as $portData) {
            $port = new Port();
            $port->setSceSem($portData['sce_sem'] ?? null);
            $port->setSceGeo($portData['sce_geo'] ?? null);
            $port->setOrigine($portData['origine'] ?? null);
            $port->setName($portData['name'] ?? null);
            $port->setType($portData['type'] ?? null);
            $port->setProvince($portData['province'] ?? null);
            $port->setAdministrative($portData['administrative'] ?? null);
            $port->setFile($portData['file'] ?? null);
            $port->setCodeGrpt($portData['code_grpt'] ?? null);
            
            // Associer à l'entité Province si disponible
            if (!empty($portData['province']) && isset($provinceMapping[$portData['province']])) {
                $port->setProvinceEntity($provinceMapping[$portData['province']]);
            }
            
            $manager->persist($port);
        }
    }

    private function loadRailwayStations(ObjectManager $manager): void
    {
        $railwayData = json_decode(file_get_contents($this->dataPath . 'railwayStations.json'), true);
        
        // Récupérer toutes les provinces pour le mapping
        $provinces = $manager->getRepository(Province::class)->findAll();
        $provinceMapping = [];
        foreach ($provinces as $province) {
            $provinceMapping[$province->getName()] = $province;
        }

        foreach ($railwayData['railwayStations'] as $stationData) {
            $station = new RailwayStation();
            $station->setSceSem($stationData['sce_sem'] ?? null);
            $station->setSceGeo($stationData['sce_geo'] ?? null);
            $station->setOrigine($stationData['origine'] ?? null);
            $station->setName($stationData['name'] ?? null);
            $station->setProvince($stationData['province'] ?? null);
            $station->setDistrict($stationData['DISTRICT'] ?? null);
            $station->setFile($stationData['file'] ?? null);
            
            // Conversion des valeurs booléennes et entières
            if (isset($stationData['breakdown'])) {
                $station->setBreakdown((bool) $stationData['breakdown']);
            }
            if (!empty($stationData['atelier'])) {
                $station->setAtelier((int) $stationData['atelier']);
            }
            
            // Conversion de la date
            if (!empty($stationData['updatedAT'])) {
                $station->setUpdatedAt(new \DateTime($stationData['updatedAT']));
            }
            
            // Associer à l'entité Province si disponible
            if (!empty($stationData['province']) && isset($provinceMapping[$stationData['province']])) {
                $station->setProvinceEntity($provinceMapping[$stationData['province']]);
            }
            
            $manager->persist($station);
        }
    }

    private function loadAdministratives(ObjectManager $manager): void
    {
        $administrativesData = json_decode(file_get_contents($this->dataPath . 'administratives.json'), true);
        
        foreach ($administrativesData['administratives'] as $administrativeData) {
            $administrative = new Administrative();
            $administrative->setName($administrativeData['name']);
            $administrative->setPrincipalTown($administrativeData['principalTown']);
            $administrative->setSurface($administrativeData['surface']);
            $administrative->setPopulation($administrativeData['population']);
            
            if (isset($administrativeData['latlng'])) {
                $administrative->setLatitude($administrativeData['latlng']['lat']);
                $administrative->setLongitude($administrativeData['latlng']['lng']);
            }
            
            $manager->persist($administrative);
        }
    }

    private function loadTerritoires(ObjectManager $manager): void
    {
        $territoiresData = json_decode(file_get_contents($this->dataPath . 'pcode_territoire.json'), true);
        
        if (!$territoiresData || !isset($territoiresData['pcode_territoire'])) {
            return;
        }
        
        foreach ($territoiresData['pcode_territoire'] as $territoireData) {
            $territoire = new Territoire();
            $territoire->setProvince($territoireData['province']);
            $territoire->setPcodeProvince($territoireData['pcode_province']);
            $territoire->setTerritoire($territoireData['territoire']);
            $territoire->setPcodeTerritoire($territoireData['pcode_territoire']);
            
            $manager->persist($territoire);
        }
    }

    private function loadZoneSantes(ObjectManager $manager): void
    {
        $zonesSanteData = json_decode(file_get_contents($this->dataPath . 'zonesante_pop2020.json'), true);
        
        if (!$zonesSanteData || !isset($zonesSanteData['zs_pop_2k20'])) {
            return;
        }
        
        foreach ($zonesSanteData['zs_pop_2k20'] as $zoneData) {
            $zoneSante = new ZoneSante();
            $zoneSante->setProvince($zoneData['province']);
            $zoneSante->setPcodeProvince($zoneData['pcode_province']);
            $zoneSante->setTerritoire($zoneData['territoire']);
            $zoneSante->setPcodeTerritoire($zoneData['pcode_terrtoire']);
            $zoneSante->setZoneDeSante($zoneData['zone_de_sante']);
            $zoneSante->setPcodeZs($zoneData['pcode_zs']);
            $zoneSante->setPop2019($zoneData['pop_2019']);
            $zoneSante->setPop2020($zoneData['pop_2020 ']);
            
            $manager->persist($zoneSante);
        }
    }
}
