<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Compagnie;
use App\Entity\Image;
use App\Repository\CompagnieRepository;
use Symfony\Component\HttpFoundation\Request;





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
     * @Route("/gestion", name="gestion")
     */
    public function gestion()
    {
        return $this->render('gestion.html.twig');
    }

    //anis



    /**
     * @Route("/front", name="front")
     */
    public function front(Request $request, CompagnieRepository $compRepository, EntityManagerInterface $entityManager)
    {
        $compagnie = $entityManager->getRepository(Compagnie::class)->findAll();
        $image = $entityManager->getRepository(Image::class)->findAll();
        return $this->render('base-front.html.twig', ['compagnie' => $compagnie, 'image' => $image]);
    }

    /**
     * @Route("/stats", name="stats")
     *
     */
    public function statistiques(CompagnieRepository $compRepo)
    {
        // On va chercher toutes les catégories
        $compagnies = $compRepo->findAll();

        $compNom = [];
        $compColor = [];
        $compCount = [];

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach ($compagnies as $compagnie) {
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
