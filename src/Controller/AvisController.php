<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Repository\AvisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/avis")
 */
class AvisController extends Controller
{
    /**
     * @Route("/", name="app_avis_index", methods={"GET"})
     */
    public function index(AvisRepository $avisRepository, Request $request , PaginatorInterface $paginator) 
    {
  
        $allAvis = $avisRepository->findAll();
        $avis = $this->get('knp_paginator')->paginate(
            $allAvis,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );

        return $this->render('avis/index.html.twig', [
            'avis' => $avis,
        ]);
    }

    /**
     * @Route("/new", name="app_avis_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AvisRepository $avisRepository): Response
    {
        $avi = new Avis();
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avisRepository->add($avi);
            return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avis/new.html.twig', [
            'avi' => $avi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_avis_show", methods={"GET"})
     */
    public function show(Avis $avi ,Request $request)
    {
    

        return $this->render('avis/show.html.twig', [
            'avi' => $avi,
  
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_avis_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Avis $avi, AvisRepository $avisRepository): Response
    {
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avisRepository->add($avi);
            return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avis/edit.html.twig', [
            'avi' => $avi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_avis_delete", methods={"POST"})
     */
    public function delete(Request $request, Avis $avi, AvisRepository $avisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avi->getId(), $request->request->get('_token'))) {
            $avisRepository->remove($avi);
        }

        return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
    }


  /**
     * @Route("/avi56a6s1d2/avi56a6s1d2", name="avi_serach", methods={"GET"})
     */
    public function search(Request $request,AvisRepository $avisRepository): Response
    {
        return $this->render('avis/index.html.twig', [
            'avis' => $avisRepository->findInput($request->get("value")),
        ]);
    }


}
