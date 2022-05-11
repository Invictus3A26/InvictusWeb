<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Vols;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\BarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use MercurySeries\FlashyBundle\FlashyNotifier;


class IndexController extends AbstractController
{
    /**
     * @Route("/home", name="app_index")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'IndexController',
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
     * @Route("/gestionVol", name="gestionVol")
     */
    public function gestion(FlashyNotifier $flashy)
    {
        $flashy->success('Event created!', 'http://your-awesome-link.com');
        return $this->render('gestionVol.html.twig');
    }




    /**
     * @Route("/front", name="front", methods={"GET"})
     */
    public function front(EntityManagerInterface $entityManager): Response
    {
        $vols = $entityManager
            ->getRepository(Vols::class)
            ->findAll();

        return $this->render('front.html.twig', [
            'vols' => $vols,
        ]);
    }







    /**
     * @Route("/about", name="about")
     */
    public function about(FlashyNotifier $flashy)
    {

        return $this->render('test.html.twig');
    }
}
