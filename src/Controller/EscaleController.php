<?php

namespace App\Controller;

use App\Entity\Escale;
use App\Form\EscaleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/escale")
 */
class EscaleController extends AbstractController
{
    /**
     * @Route("/", name="app_escale_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $escales = $entityManager
            ->getRepository(Escale::class)
            ->findAll();

        return $this->render('escale/index.html.twig', [
            'escales' => $escales,
        ]);
    }

    /**
     * @Route("/new", name="app_escale_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $escale = new Escale();
        $form = $this->createForm(EscaleType::class, $escale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($escale);
            $entityManager->flush();

            return $this->redirectToRoute('app_escale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('escale/new.html.twig', [
            'escale' => $escale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEscale}", name="app_escale_show", methods={"GET"})
     */
    public function show(Escale $escale): Response
    {
        return $this->render('escale/show.html.twig', [
            'escale' => $escale,
        ]);
    }

    /**
     * @Route("/{idEscale}/edit", name="app_escale_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Escale $escale, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EscaleType::class, $escale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_escale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('escale/edit.html.twig', [
            'escale' => $escale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEscale}", name="app_escale_delete", methods={"POST"})
     */
    public function delete(Request $request, Escale $escale, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$escale->getIdEscale(), $request->request->get('_token'))) {
            $entityManager->remove($escale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_escale_index', [], Response::HTTP_SEE_OTHER);
    }
}
