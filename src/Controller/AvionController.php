<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvionController extends AbstractController
{
    /**
     * @Route("/avion", name="app_avion")
     */
    public function index(): Response
    {
        return $this->render('avion/index.html.twig', [
            'controller_name' => 'AvionController',
        ]);
    }

    /**
     * @return Response
     * @Route ("/afficheA",name="afficheA")
     */
    public function  afficheA (){
        return new  Response("Bonjour Aziz");
    }

    /**
     * @param $name
     * @return Response
     * @Route ("/afficheAN/{name}",name="afficheAN")
     */
    public function afficheAN ($name){
        return $this->render('avion/afficheAN.html.twig',['n'=>$name]);
    }
}
