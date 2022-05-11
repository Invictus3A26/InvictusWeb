<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Entity\Search;
use App\Form\SearchReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\BarChart;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RechercheType;

/**
 * @Route("/reclamation")
 */
class ReclamationController extends Controller
{
    /**
     * @Route("/", name="app_reclamation_index")
     */
    public function index(ReclamationRepository $reclamationRepository, EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
    {

        $reclamations = $entityManager->getRepository(Reclamation::class)->findAll();
        $form = $this->createForm(RechercheType::class);

        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamations = $reclamationRepository->search(
                $search->get('mot')->getData()

            );
        }

        $allReclamation = $reclamationRepository->findAll();

        $reclamations = $this->get('knp_paginator')->paginate(
            $allReclamation,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/listr", name="app_reclamation_list", methods={"GET"})
     */
    public function listr(ReclamationRepository $reclamationRepository): Response
    {

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $reclamations = $reclamationRepository->findAll();



        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('reclamation/listr.html.twig', [
            'reclamations' => $reclamations,

        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }

    /**
     * @Route("/new", name="app_reclamation_new", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, \Swift_Mailer $mailer)
    {


        $reclamation = new reclamation();

        $form = $this->createForm(ReclamationType::class, $reclamation);



        $form->handleRequest($request);
        $myDictionary = array(
            "tue", "merde",
            "gueule",
            "débile",
            "con",
            "abruti",
            "clochard",
            "sang"
        );
        dump($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $myText = $request->get("reclamation")['description'];
            $badwords = new PhpBadWordsController();
            $badwords->setDictionaryFromArray($myDictionary)
                ->setText($myText);
            $check = $badwords->check();
            dump($check);
            if ($check) {
                $this->addFlash(
                    'erreur',
                    'Mot inapproprié!',
                );
            } else {


                $entityManager = $this->getdoctrine()->getManager();
                $entityManager->persist($reclamation);



                $message = (new \Swift_Message('Hello'))
                    ->setFrom("radhitl46@gmail.com")
                    ->setTo("amenallah.benkhalifa@esprit.tn")
                    ->setBody('Votre reclamation a était envoyé ');
                $mailer->send($message);
                if (!$mailer->send($message, $failures)) {
                    echo "Failures:";
                    print_r($failures);
                }
                $entityManager->flush();
                $this->addFlash(
                    'info',
                    'Reclamation ajouté !!',
                );
            }

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),

        ]);
    }


    /**
     * @Route("/{id}", name="app_reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation, Request $request): Response
    {


        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_reclamation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->add($reclamation);
            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reclamation->getId(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation);
        }

        $this->addFlash('message', 'Votre ajout est complete');


        $this->addFlash(
            'info',
            ' le Reclamation a été supprimer',
        );



        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     *@Route("/statisreclamation", name="statisreclamation")
 
     */

    public function statisreclamation(ReclamationRepository $ReclamationRepository)
    {
        //on va chercher les categories
        $rech = $ReclamationRepository->barDep();
        $arr = $ReclamationRepository->barArr();

        $bar = new barChart();
        $bar->getData()->setArrayToDataTable(
            [
                ['reclamation', 'type'],
                ['bagage', intVal($rech)],
                ['diwana', intVal($arr)]

            ]
        );

        $bar->getOptions()->setTitle('les Reclamations');
        $bar->getOptions()->getHAxis()->setTitle('Nombre de reclamation');
        $bar->getOptions()->getHAxis()->setMinValue(0);
        $bar->getOptions()->getVAxis()->setTitle('Type');
        $bar->getOptions()->SetWidth(800);
        $bar->getOptions()->SetHeight(400);


        return $this->render('reclamation/statisreclamation.html.twig', array('bar' => $bar));
    }


    /**
     * @Route("/tri", name="tri")
     */
    public function Tri()
    {
        $reclamations = $this->getDoctrine()->getRepository(Reclamation::class)->TriParnom();
        return $this->render("reclamation/tri.html.twig", array('reclamations' => $reclamations));
    }


    /**
     * @Route("/rec56a6s1d2/rec56a6s1d2", name="rec_serach", methods={"GET"})
     */
    public function search(Request $request, ReclamationRepository $reclamationRepository): Response
    {

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findInput($request->get("value")),
        ]);
    }








    /**
     * @Route("/chart", name="rec_serach")
     */

    public function indexAction()
    {
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [
                ['Task', 'Hours per Day'],
                ['Work',     11],
                ['Eat',      2],
                ['Commute',  2],
                ['Watch TV', 2],
                ['Sleep',    7]
            ]
        );
        $pieChart->getOptions()->setTitle('My Daily Activities');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('chart.html.twig', array('piechart' => $pieChart));
    }
}
