<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\DepartementRepository;
use App\Entity\Departement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DepartementMobileController extends AbstractController
{
    /**
     * @Route("/departement/mobile", name="app_departement_mobile")
     */
    public function index(): Response
    {
        return $this->render('departement_mobile/index.html.twig', [
            'controller_name' => 'DepartementMobileController',
        ]);
    }
    /**
     * @Route("/list/departement", name="listdepartement")
     */
    public function getDepartement(EntityManagerInterface $em,NormalizerInterface $Normalizer)
    {
        $departement=$em
        ->getRepository(Departement::class)
        ->findAll();

        $jsonContent=$Normalizer->normalize($departement, 'json', ['groups'=>'departement']);
        
        return new Response(json_encode($jsonContent));
    }
    /**
     * @Route("/adddepartement", name="add_departement", methods={"POST"})
     */
    public function add_departement( NormalizerInterface $normalizable, EntityManagerInterface $entityManager, Request $request)
    {
        
        $departements = new Departement();


        $departements->setNomdepartement($request->get('nomDepartement'));
        $departements->setZonedepartement($request->get('zoneDepartement'));
        $departements->setDetaildepartement($request->get('detailDepartement'));
        
        $entityManager->persist($departements);
        $entityManager->flush();
        return new JsonResponse([
            'success' => "departements has been added"
        ]);
    }
    
    /**
     * @Route("/remove/Departement/{id}",name="removeDepartement")
     */

    public function removeDepartement(DepartementRepository $departementRepository,$id):Response
    {

        $cat=$departementRepository->find($id);
        $this->getDoctrine()->getManager()->remove($cat);

        $this->getDoctrine()->getManager()->flush();
        return $this->json(array('title'=>'successful','message'=> "departement supprimé avec succès"),200);

    }
    /**
     * @Route("/edit/departement/{id}",name="editDepartement")
     */

    public function editDepartement(Request $request, EntityManagerInterface $em,$id):Response
    {
        $departement=$em
        ->getRepository(Departement::class)
        ->find($id);
        $departement->setNomdepartement($request->get('nomDepartement'));
        $departement->setZonedepartement($request->get('zoneDepartement'));
        $departement->setDetaildepartement($request->get('detailDepartement'));





        $this->getDoctrine()->getManager()->persist($departement);

        $this->getDoctrine()->getManager()->flush();
        return $this->json(array('title'=>'successful','message'=> "Departement modifié avec succès"),200);

    }
}
