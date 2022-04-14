<?php

namespace App\Controller;

use App\Entity\Bagage;
use App\Form\BagageType;
use App\Repository\BagageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bagage")
 */
class BagageController extends AbstractController
{
    /**
     * @Route("/", name="app_bagage_index", methods={"GET"})
     */
    public function index(BagageRepository $bagageRepository): Response
    {
        return $this->render('bagage/index.html.twig', [
            'bagages' => $bagageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_bagage_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BagageRepository $bagageRepository): Response
    {
        $bagage = new Bagage();
        $form = $this->createForm(BagageType::class, $bagage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bagageRepository->add($bagage);
            return $this->redirectToRoute('app_bagage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bagage/new.html.twig', [
            'bagage' => $bagage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_bagage_show", methods={"GET"})
     */
    public function show(Bagage $bagage): Response
    {
        return $this->render('bagage/show.html.twig', [
            'bagage' => $bagage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_bagage_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Bagage $bagage, BagageRepository $bagageRepository): Response
    {
        $form = $this->createForm(BagageType::class, $bagage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bagageRepository->add($bagage);
            return $this->redirectToRoute('app_bagage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bagage/edit.html.twig', [
            'bagage' => $bagage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_bagage_delete", methods={"POST"})
     */
    public function delete(Request $request, Bagage $bagage, BagageRepository $bagageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bagage->getId(), $request->request->get('_token'))) {
            $bagageRepository->remove($bagage);
        }

        return $this->redirectToRoute('app_bagage_index', [], Response::HTTP_SEE_OTHER);
    }
}
