<?php

namespace App\Controller;

use App\Entity\Bagage;
use App\Form\BagageType;
use App\Repository\BagageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Form\SearchBagageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Knp\Component\Pager\PaginatorInterface;



/**
 * @Route("/bagage")
 */
class BagageController extends AbstractController
{
    /**
     * @Route("/", name="app_bagage_index")
     */
    public function index(Request $request, BagageRepository $bagageRepository, EntityManagerInterface $entityManager)
    {
        $bagages = $entityManager->getRepository(Bagage::class)->findAll();
        $form = $this->createForm(SearchBagageType::class);

        $search = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On recherche les bagages correspondant aux mots clés
            $bagages = $bagageRepository->search(
                $search->get('mots')->getData()

            );
        }

        return $this->render('bagage/index.html.twig', [
            'bagages' => $bagages,
            'form' => $form->createView()
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
            $this->addFlash(
                'info',
                'Added successfuly',
            );
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
    public function show(Bagage $bagage, Request $request): Response

    {
        $bagage = $this->get('knp_paginator')->paginate(

            $bagage,

            $request->query->getInt('page', 1),

            3
        );
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
            $this->addFlash(
                'info',
                'Edit successfuly',
            );
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
        if ($this->isCsrfTokenValid('delete' . $bagage->getId(), $request->request->get('_token'))) {
            $bagageRepository->remove($bagage);
            $this->addFlash(
                'info',
                'Deleted successfuly',
            );
        }

        return $this->redirectToRoute('app_bagage_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/api/excel", name="excel")
     */
    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $Bagage = $this->getDoctrine()
            ->getRepository(Bagage::class)
            ->findAll();
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "poids");
        $sheet->setCellValue('B1', "dimension");
        $i = 2;
        foreach ($Bagage as $Bagage) {
            $sheet->setCellValue('A' . $i, $Bagage->getPoids());
            $sheet->setCellValue('B' . $i, $Bagage->getDimension());

            $i++;
        }


        $sheet->setTitle("Bagage passager");

        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = 'Bagage_passager.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("/api/excel1/{id}", name="excel1")
     */
    public function excel1($id, BagageRepository $rep)
    {
        $spreadsheet = new Spreadsheet();
        $Bagage = $rep->findBy($id);
        $em = $this->getDoctrine()->getManager();




        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "poids");

        $i = 2;
        foreach ($Bagage as $bagage) {
            $sheet->setCellValue('A' . $i, $bagage->getPoids());


            $i++;
        }
        $Dimension = $this->getDoctrine()
            ->getRepository(Tournoi::class)
            ->find($id);
        $nom = "Participants du tournoi " . $Dimension->getDimension();
        $sheet->setDimension($Dimension);

        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = $nom . '.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
