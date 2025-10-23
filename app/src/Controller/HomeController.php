<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        // On peut lister les liens vers les API ici
        $apis = [
            ['name' => 'Administratives', 'url' => '/api/administratives'],
            ['name' => 'Aéroport', 'url' => '/api/airports'],
            ['name' => 'Villes', 'url' => '/api/cities'],
            ['name' => 'Ports', 'url' => '/api/ports'],
            ['name' => 'Chémin de fer', 'url' => '/api/railway_stations'],
            ['name' => 'Territoires', 'url' => '/api/territoires'],
            ['name' => 'Zones de Santé', 'url' => '/api/zone_santes'],
            // ajoute toutes tes autres entités ici
        ];

        return $this->render('home/index.html.twig', [
            'apis' => $apis,
        ]);
    }
}
