<?php

namespace App\Controller;

use App\Entity\Compagnie;
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



}
