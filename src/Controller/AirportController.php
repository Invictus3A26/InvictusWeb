<?php

namespace App\Controller;

use App\Entity\Airport;
use App\Form\AirportType;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/airport")
 */
class AirportController extends AbstractController
{
    /**
     * @Route("/", name="app_airport_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $airports = $entityManager
            ->getRepository(Airport::class)
            ->findAll();

        return $this->render('airport/index.html.twig', [
            'airports' => $airports,
        ]);
    }

    /**
     * @Route("/new", name="app_airport_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $airport = new Airport();
        $form = $this->createForm(AirportType::class, $airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($airport);
            $entityManager->flush();
           
            $flashy->success('Aèroport Ajouter !');
            return $this->redirectToRoute('app_airport_index', [], Response::HTTP_SEE_OTHER);
            
        }

        return $this->render('airport/new.html.twig', [
            'airport' => $airport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAeroport}", name="app_airport_show", methods={"GET"})
     */
    public function show(Airport $airport): Response
    {
        return $this->render('airport/show.html.twig', [
            'airport' => $airport,
        ]);
    }

    /**
     * @Route("/{idAeroport}/edit", name="app_airport_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Airport $airport, EntityManagerInterface $entityManager ,FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(AirportType::class, $airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $flashy->info('Aèroport Modifié !');
            return $this->redirectToRoute('app_airport_index', [], Response::HTTP_SEE_OTHER);
           
        }

        return $this->render('airport/edit.html.twig', [
            'airport' => $airport,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idAeroport}", name="app_airport_delete", methods={"POST"})
     */
    public function delete(Request $request, Airport $airport, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$airport->getIdAeroport(), $request->request->get('_token'))) {
            $entityManager->remove($airport);
            $entityManager->flush();
            $flashy->error('Aèroport Supprimer !');
        }

        return $this->redirectToRoute('app_airport_index', [], Response::HTTP_SEE_OTHER);
    }
}
