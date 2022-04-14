<?php

namespace App\Controller;

use App\Entity\Fraisbagage;
use App\Form\FraisbagageType;
use App\Repository\FraisbagageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/fraisbagage")
 */
class FraisbagageController extends AbstractController
{
    /**
     * @Route("/", name="app_fraisbagage_index", methods={"GET"})
     */
    public function index(FraisbagageRepository $fraisbagageRepository): Response
    {
        return $this->render('fraisbagage/index.html.twig', [
            'fraisbagages' => $fraisbagageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_fraisbagage_new", methods={"GET", "POST"})
     */
    public function new (Request $request,FraisbagageRepository $fraisbagageRepository ,EntityManagerInterface $entityManager)
    {

        $Fraisbagage= new Fraisbagage();

        $form = $this ->createForm(FraisbagageType::class,$Fraisbagage);


        $form->handleRequest($request)  ;

        if ($form->isSubmitted() && $form->isValid()) {
            $fraisbagageRepository->add($Fraisbagage);
            return $this->redirectToRoute('app_fraisbagage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Fraisbagage/new.html.twig', [
            'Fraisbagage' => $Fraisbagage,
            'form' => $form->createView(),
        ]);
    }






    /**
     * @Route("/{id}", name="app_fraisbagage_show", methods={"GET"})
     */
    public function show(Fraisbagage $fraisbagage): Response
    {
        return $this->render('fraisbagage/show.html.twig', [
            'fraisbagage' => $fraisbagage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_fraisbagage_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Fraisbagage $fraisbagage, FraisbagageRepository $fraisbagageRepository): Response
    {
        $form = $this->createForm(FraisbagageType::class, $fraisbagage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fraisbagageRepository->add($fraisbagage);
            return $this->redirectToRoute('app_fraisbagage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fraisbagage/edit.html.twig', [
            'fraisbagage' => $fraisbagage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_fraisbagage_delete", methods={"POST"})
     */
    public function delete(Request $request, Fraisbagage $fraisbagage, FraisbagageRepository $fraisbagageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fraisbagage->getId(), $request->request->get('_token'))) {
            $fraisbagageRepository->remove($fraisbagage);
        }

        return $this->redirectToRoute('app_fraisbagage_index', [], Response::HTTP_SEE_OTHER);
    }
}
