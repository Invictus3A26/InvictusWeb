<?php

namespace App\Controller;

use App\Entity\Avion;
use App\Form\AvionType;
use App\Form\SearchAvionType;
use App\Repository\AvionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/avion")
 */
class AvionController extends AbstractController
{
    /**
     * @Route("/", name="app_avion_index")
     */
    public function index(Request $request , AvionRepository $avRepository,EntityManagerInterface $entityManager)
    {
        $avions=$entityManager->getRepository(Avion::class)->findAll();
        $form = $this->createForm(SearchAvionType::class);

        $search = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // On recherche les compagnies correspondant aux mots clés
            $avions = $avRepository->search(
                $search->get('mots')->getData()

            );
        }

        return $this->render('avion/index.html.twig', [
            'avions' =>  $avions,
            'form' => $form->createView()]);
    }


    /**
     * @Route("/new", name="app_avion_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AvionRepository $avionRepository): Response
    {
        $avion = new Avion();
        $form = $this->createForm(AvionType::class, $avion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avionRepository->add($avion);
            return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avion/new.html.twig', [
            'avion' => $avion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_avion_show", methods={"GET"})
     */
    public function show(Avion $avion): Response
    {
        return $this->render('avion/show.html.twig', [
            'avion' => $avion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_avion_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Avion $avion, AvionRepository $avionRepository): Response
    {
        $form = $this->createForm(AvionType::class, $avion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avionRepository->add($avion);
            return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avion/edit.html.twig', [
            'avion' => $avion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_avion_delete", methods={"POST"})
     */
    public function delete(Request $request, Avion $avion, AvionRepository $avionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avion->getId(), $request->request->get('_token'))) {
            $avionRepository->remove($avion);
        }

        return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
    }
}
