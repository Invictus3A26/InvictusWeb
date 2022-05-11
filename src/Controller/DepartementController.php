<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DepartementRepository;
use App\Form\SearchDepartementType;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;




/**
 * @Route("/departement")
 */
class DepartementController extends AbstractController
{
    /**
     * @Route("/", name="app_departement_index")
     */
    public function index(Request $request , DepartementRepository $depRepository,EntityManagerInterface $entityManager,PaginatorInterface $page    )
    {
          $departement=$entityManager->getRepository(Departement::class)->findAll();
        $form = $this->createForm(SearchDepartementType::class);

            $search = $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                // On recherche les departement correspondant aux mots clés
                $departement = $depRepository->search(
                    $search->get('mots')->getData()

                );
            }
            $donnees =$page->paginate(
                $departement , $request->query->getInt('page',1),3
             );

            return $this->render('departement/index.html.twig', [
                'departements' => $donnees,
                'form' => $form->createView()]);
                }

    /**
     * @Route("/new", name="app_departement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,FlashyNotifier $flashy): Response
    {
        $departement = new Departement();
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($departement);
            $entityManager->flush();
            $flashy->success('Departement Ajoutée !');


            return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('departement/new.html.twig', [
            'departement' => $departement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_departement_show", methods={"GET"})
     */
    public function show(Departement $departement): Response
    {
        return $this->render('departement/show.html.twig', [
            'departement' => $departement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_departement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Departement $departement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('departement/edit.html.twig', [
            'departement' => $departement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_departement_delete", methods={"POST"})
     */
    public function delete(Request $request, Departement $departement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$departement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($departement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/all/departements", name="departements", methods={"GET"})
     */
    public function mobile_all_departements(NormalizerInterface $normalizable, DepartementRepository $departementRepository, Request $request)
    {
        $departements = $departementRepository->findAll();
        //  dd($users);
        $jsonContent = $normalizable->normalize($departements, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/all/departementss", name="departements")
     */
    public function departements(NormalizerInterface $normalizer): Response
    {
        $departements = $this->getDoctrine()->getRepository(Departement::class)->findAll();


        $jsonData=array();
        $prd=array();
        $i=0;
        foreach ($departements as $dep) {

            $prd = array(

                'id' => $dep->getId(),
                'nomDepartement' => $dep->getNomdepartement(),
                'zoneDepartement' => $dep->getZonedepartement(),
                'detailDepartement' => $dep->getDetaildepartement(),


            );
            $jsonData[$i++] = $prd;
        }
            return new Response(
                json_encode($jsonData), 200, ['Accept' => 'application/json',
                'Content-Type' => 'application/json']);
        }

    
}
