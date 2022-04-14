<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equipements;

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
     * @Route("/front", name="front", methods={"GET"})
     */
    public function front(EntityManagerInterface $entityManager): Response
    {
        $equipement = $entityManager
            ->getRepository(Equipements::class)
            ->findAll();

        return $this->render('base.html.twig', [
            'equipements' => $equipement,
        ]);
    }
    /**
     * @Route("/gestion", name="gestion")
     */
    public function gestion()
    {
        return $this->render('gestion.html.twig');
    }
    
}
