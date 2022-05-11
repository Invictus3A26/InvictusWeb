<?php

namespace App\Controller;

use App\Entity\Fraisbagage;
use App\Form\FraisbagageType;
use App\Repository\BagageRepository;
use App\Repository\FraisbagageRepository;
use App\services\QrCodeService;
use ContainerFi1YNxt\PaginatorInterface_82dac15;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/fraisbagage")
 */
class FraisbagageController extends Controller
{
    /**
     * @Route("/", name="app_fraisbagage_index", methods={"GET"})
     */
    public function index(FraisbagageRepository $fraisbagageRepository, Request $request): Response
    {
        $allfrais = $fraisbagageRepository->findAll();
        $fraisbagage = $this->get('knp_paginator')->paginate(
            $allfrais,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );
        return $this->render('fraisbagage/index.html.twig', [
            'fraisbagage' => $fraisbagage,
        ]);
    }

    /**
     * @Route("/new", name="app_fraisbagage_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FraisbagageRepository $fraisbagageRepository, EntityManagerInterface $entityManager)
    {

        $Fraisbagage = new Fraisbagage();

        $form = $this->createForm(FraisbagageType::class, $Fraisbagage);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fraisbagageRepository->add($Fraisbagage);
            $this->addFlash(
                'info',
                'Added successfuly',
            );
            return $this->redirectToRoute('app_fraisbagage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fraisbagage/new.html.twig', [
            'Fraisbagage' => $Fraisbagage,
            'form' => $form->createView(),
        ]);
    }






    /**
     * @Route("/{id}", name="app_fraisbagage_show", methods={"GET"})
     */
    public function show(Fraisbagage $fraisbagage, QrCodeService $qrcodeService): Response
    {
        $qrCode = null;

        $url = 'Tarif de base: ' . $fraisbagage->getTarifsBase() . ' | ';
        $url = $url . 'Tarif comfort: ' . $fraisbagage->getTarifsConfort() . ' | ';
        $url = $url . 'Montant: ' . $fraisbagage->getMontant() . ' | ';


        $qrCode = $qrcodeService->qrcode($url);


        return $this->render('fraisbagage/show.html.twig', [
            'fraisbagage' => $fraisbagage,
            'qrCode' => $qrCode
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
        if ($this->isCsrfTokenValid('delete' . $fraisbagage->getId(), $request->request->get('_token'))) {
            $fraisbagageRepository->remove($fraisbagage);
        }

        return $this->redirectToRoute('app_fraisbagage_index', [], Response::HTTP_SEE_OTHER);
    }
}
