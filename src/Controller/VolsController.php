<?php

namespace App\Controller;

use App\Entity\Vols;
use App\Form\RechercherType;
use App\Form\VolsType;
use App\Repository\VolsRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\BarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vols")
 */
class VolsController extends AbstractController
{
    /**
     * @Route("/", name="app_vols_index")
     */
    public function index(Request $request, VolsRepository $volRep,EntityManagerInterface $entityManager, PaginatorInterface $page): Response
    {
        $vols = $entityManager
        ->getRepository(Vols::class)
        ->findAll();

       
        $form = $this->createForm(RechercherType::class);

        $search = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           
            $vols = $volRep->search(
                $search->get('mot')->getData()

            );

         
        }
        $donnees =$page->paginate(
            $vols , $request->query->getInt('page',1),5
         );
        return $this->render('vols/index.html.twig', [
            'vols' => $donnees,
            'Searchform' => $form->createView()]);
            
    }

    /**
     * @Route("/new", name="app_vols_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $vol = new Vols();
        $form = $this->createForm(VolsType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vol);
            $entityManager->flush();
            $flashy->success('Vol Ajoutée !');
            return $this->redirectToRoute('app_vols_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vols/new.html.twig', [
            'vol' => $vol,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idVol}", name="app_vols_show", methods={"GET"})
     */
    public function show(Vols $vol): Response
    {
        return $this->render('vols/show.html.twig', [
            'vol' => $vol,
        ]);
    }

    /**
     * @Route("/{idVol}/edit", name="app_vols_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Vols $vol, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(VolsType::class, $vol);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $flashy->info('Vol Modifié !');
            return $this->redirectToRoute('app_vols_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vols/edit.html.twig', [
            'vol' => $vol,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idVol}", name="app_vols_delete", methods={"POST"})
     */
    public function delete(Request $request, Vols $vol, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vol->getIdVol(), $request->request->get('_token'))) {
            $entityManager->remove($vol);
            $entityManager->flush();
            $flashy->error('Vol Supprimer !');
        }

        return $this->redirectToRoute('app_vols_index', [], Response::HTTP_SEE_OTHER);
    }






    public function search( VolsRepository $volRep){
        $rech = $volRep->search('r');
    }
  



  /**
     * @Route("/test/1", name="test")
     */
    public function indexAction(EntityManagerInterface $em,VolsRepository $volRep)
    {
        
       

        $rech = $volRep->barDep();
        $arrbar = $volRep->barArr();
        $dep = $volRep->sumDep();
        $arr = $volRep->sumArr();
        
        
         
     
       

        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable([
            
            ['City', 'nombre vol'],
            ['Num vols depart',intVal($rech)],
            ['Num vols arrivé ', intVal($arrbar)]
          
        ]);
        $bar->getOptions()->setTitle('Nombre des vols departs et arrivées');
        $bar->getOptions()->getHAxis()->setTitle('TNombre vol');
        $bar->getOptions()->getHAxis()->setMinValue(0);
        $bar->getOptions()->getVAxis()->setTitle('Type vol');
        $bar->getOptions()->setWidth(500);
        $bar->getOptions()->setHeight(300);


        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
             ['Nombre passagés entrant du aeroport',     intVal($arr)],
             ['Nombre passagés sortant du aeroport',      intVal($dep)]
             
            ]
        );
        $pieChart->getOptions()->setTitle('nombre des passagers totales');
        $pieChart->getOptions()->setHeight(300);
        $pieChart->getOptions()->setWidth(500);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);





    
        return $this->render('test.html.twig', array('piechart' => $bar,'pie' => $pieChart));





    }

    


}
