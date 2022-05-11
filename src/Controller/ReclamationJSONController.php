<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/reclamationn")
 */

class ReclamationJSONController extends AbstractController
{
    /**
     * @Route("/allReclamations", name="app_reclamation")
     */
    public function index(NormalizerInterface $normalizer): Response
    {
        $reclamations = $this->getDoctrine()->getManager()
            ->getRepository(Reclamation::class)
            ->findAll();

        $jsonContent = $normalizer->normalize($reclamations,'json',['groups'=>'reclamation']);

        return new JsonResponse($jsonContent);

    }

    /**
     * @Route("/detailReclamation", name="detail_Reclamation")
     */

    public function detailReclamation(Request $request)
    {
        $id=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $reclamation=$em->getRepository(Reclamation::class)->find($id);
        $encoder= new JsonEncoder();
        $normalizer=new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object){
            return $object->getDescription;
        });
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($reclamation);

        return new JsonResponse($formatted);


    }

    /**
     * @Route("/addReclamation", name="add_reclamation")
     */

    public function ajouterReclamationAction(Request $request){

        $reclamation= new Reclamation();
        $em = $this->getDoctrine()->getManager();
        $reclamation->setNom($request->get("nom"));
        $reclamation->setPrenom($request->get("prenom"));
        $reclamation->setEmail($request->get("email"));
        $reclamation->setTel($request->get("tel"));
        $reclamation->setEtat($request->get("etat"));
        $reclamation->setDescription($request->get("description"));
        $reclamation->setDate_reclamation($request->get("date_reclamation"));

        $em->persist($reclamation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation,"json",['groups'=>'reclamation']);
        return new JsonResponse($formatted);
    }


    /**
     * @Route("/updateReclamation", name="update_reclamation")
     */

    public function modifierReclamationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $reclamation = $this->getDoctrine()->getManager()
            ->getRepository(Reclamation::class)
            ->find($request->get("id"));



            $reclamation->setNom($request->get("nom"));
            $reclamation->setPrenom($request->get("prenom"));
            $reclamation->setEmail($request->get("email"));
            $reclamation->setTel($request->get("tel"));
            $reclamation->setEtat($request->get("etat"));
            $reclamation->setDescription($request->get("description"));
            $reclamation->setDate_reclamation($request->get("date_reclamation"));

        $em->persist($reclamation);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reclamation);
        return new JsonResponse("Reclamation a ete modifiee avec success.");

    }


    /**
     * @Route("/delReclamation", name="delreclamation")
     */


    public function delReclamationoffre(Request $request,NormalizerInterface $normalizer)
    {
        $em=$this->getDoctrine()->getManager();
        $rec=$this->getDoctrine()->getRepository(Reclamation::class)
            ->find($request->get("id"));
        $em->remove($rec);
        $em->flush();
        $jsonContent = $normalizer->normalize($rec,'json',['reclamation'=>'post:read']);
        return new Response(json_encode($jsonContent));
    }


}
