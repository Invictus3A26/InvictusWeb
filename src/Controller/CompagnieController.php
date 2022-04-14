<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompagnieController extends AbstractController
{
    /**
     * @Route("/compagnie", name="app_compagnie")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'CompagnieController',
        ]);

    }

    /**
     * @return Response
     * @Route("/affiche",name="affiche")
     */
    public function  affiche(){
        return new  Response('Bonjour à tous');
    }

    /**
     * @param $name
     * @return Response
     * @Route ("/afficheN/{name}",name="afficheN")
     */
    public function affichename($name){
        return $this->render('compagnie/affiche.html.twig',['n'=>$name]);

    }
}
