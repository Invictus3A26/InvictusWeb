<?php

namespace App\Controller;

use App\Entity\Compagnie;
use App\Repository\AvionRepository;
use App\Repository\CompagnieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="app_test")
     */
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('base-back.html.twig');
    }
    /**
     * @Route("/front", name="front")
     */
    public function front()
    {
        return $this->render('base-front.html.twig');
    }

    /**
     * @Route("/stats", name="stats")
     *
     */
    public function statistiques(CompagnieRepository $compRepo, AvionRepository  $avRepo)
    {
        // On va chercher toutes les catégories
        $compagnies = $compRepo->findAll();

        $compNom = [];
        $compColor = [];
        $compCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach($compagnies as $compagnie){
            $compNom[] = $compagnie->getNomCom();
            $compColor[] = $compagnie->getColor();
            $compCount[] = count($compagnie->getAvions());
        }



        return $this->render('compagnie/stats.html.twig', [
            'compNom' => json_encode($compNom),
            'compColor' => json_encode($compColor),
            'compCount' => json_encode($compCount),

        ]);
    }

}
