<?php

namespace App\Controller;

use App\Repository\BagageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestControllernidhal extends AbstractController
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
        return $this->render('base.back.html.twig');
    }
    /**
     * @Route("/gestionnidhal", name="gestionnidhal")
     */
    public function gestion()
    {
        return $this->render('test/base.gestion.html.twig');
    }
}
