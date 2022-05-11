<?php

namespace App\Controller;

use App\Entity\Fraisbagage;
use App\Entity\Bagage;
use App\Repository\BagageRepository;
use App\Repository\FraisbagageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Annotation\Groups;
use PHPUnit\Util\Json;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MobileController extends AbstractController
{
    /**
     * @Route("/allBagages", name="app_mobile")
     */
    public function index(NormalizerInterface $normalizer): Response
    {
        $bagages = $this->getDoctrine()->getManager()
            ->getRepository(Bagage::class)
            ->findAll();

        $jsonContent = $normalizer->normalize($bagages,'json',['groups'=>'fraisbagage']);

        return new JsonResponse($jsonContent);


    }

    /**
     * @Route("/detailBagage", name="detail_mobile")
     */

    public function DetailBagage(Request $request)
    {
        $id=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $bagage=$em->getRepository(Bagage::class)->find($id);
        $encoder= new JsonEncoder();
        $normalizer=new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function ($object){
            return $object->getDescription;
        });
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($bagage);

        return new JsonResponse($formatted);


    }



        /**
         * @Route("/delete/bagage/{id}",name="removeCategorie")
         */

        public function removebagage(BagageRepository $bagageRepository,$id):Response
    {

        $cat=$bagageRepository->find($id);
        $this->getDoctrine()->getManager()->remove($cat);

        $this->getDoctrine()->getManager()->flush();
        return $this->json(array('title'=>'successful','message'=> "bagage supprimé avec succès"),200);

    }
    /**
     * @Route("/AddBagage", name="ajouteEscale")
     */
    public function add_bagage( NormalizerInterface $normalizable, EntityManagerInterface $entityManager, Request $request)
    {

        $bagage = new Bagage();


        $bagage->setPoids($request->get('poids'));
        $bagage->setPoidsM($request->get('poids_m'));
        $bagage->setPoidsS($request->get('poids_s'));
        $bagage->setDimension($request->get('dimension'));
        $bagage->setNumValise($request->get('num_valise'));



        $entityManager->persist($bagage);
        $entityManager->flush();
        return new JsonResponse([
            'success' => "Bagage has been added"
        ]);
    }
    /**
     * @Route("/edit/bagage/{id}",name="editCategorie")
     */

    public function modifbagage(Request $request, EntityManagerInterface $em,$id):Response
    {
        $bagage=$em
            ->getRepository(Bagage::class)
            ->find($id);
        $bagage->setPoids($request->get('poids'));
        $bagage->setPoidsM($request->get('poids_m'));
        $bagage->setPoidsS($request->get('poids_s'));
        $bagage->setDimension($request->get('dimension'));
        $bagage->setNumValise($request->get('num_valise'));





        $this->getDoctrine()->getManager()->persist($bagage);

        $this->getDoctrine()->getManager()->flush();
        return $this->json(array('title'=>'successful','message'=> "Bagage modifié avec succès"),200);

    }

}
