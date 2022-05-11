<?php

namespace App\Controller;

use App\Entity\Equipements;
use App\Form\EquipementsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipements")
 */
class EquipementsController extends AbstractController
{
    /**
     * @Route("/", name="app_equipements_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $equipements = $entityManager
            ->getRepository(Equipements::class)
            ->findAll();

        return $this->render('equipements/index.html.twig', [
            'equipements' => $equipements,
        ]);
    }

    /**
     * @Route("/new", name="app_equipements_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipement = new Equipements();
        $form = $this->createForm(EquipementsType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipement);
            $entityManager->flush();

            return $this->redirectToRoute('app_equipements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipements/new.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_equipements_show", methods={"GET"})
     */
    public function show(Equipements $equipement): Response
    {
        return $this->render('equipements/show.html.twig', [
            'equipement' => $equipement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_equipements_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Equipements $equipement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EquipementsType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_equipements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipements/edit.html.twig', [
            'equipement' => $equipement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_equipements_delete", methods={"POST"})
     */
    public function delete(Request $request, Equipements $equipement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($equipement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_equipements_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
