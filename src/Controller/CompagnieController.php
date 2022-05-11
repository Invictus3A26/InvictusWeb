<?php

namespace App\Controller;

use App\Entity\Compagnie;
use App\Entity\Image;
use App\Entity\PropertySearch;
use App\Form\CompagnieType;
use App\Form\PropertySearchType;
use App\Form\SearchCompagnieType;
use App\Repository\AvionRepository;
use App\Repository\CompagnieRepository;
use Container8twMgLM\PaginatorInterface_82dac15;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/compagnie")
 */
class CompagnieController extends AbstractController
{
    /**
     * @Route("/", name="app_compagnie_index")
     */
    public function index(Request $request , CompagnieRepository $compRepository,EntityManagerInterface $entityManager,PaginatorInterface $paginator)
    {
          $compagnies=$entityManager->getRepository(Compagnie::class)->findAll();

        $form = $this->createForm(SearchCompagnieType::class);

            $search = $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                // On recherche les compagnies correspondant aux mots clés
                $compagnies = $compRepository->search(
                    $search->get('mots')->getData()

                );
            }
        $page = $paginator->paginate(
            $compagnies,
            $request->query->getInt('page',1),
            4
        );
            return $this->render('compagnie/index.html.twig', [
                'compagnies' => $compagnies,
                'page' => $page,
                'form' => $form->createView()]);
                }


    /**
     * @Route("/new", name="app_compagnie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CompagnieRepository $compagnieRepository,FlashyNotifier  $flashy): Response
    {
        $compagnie = new Compagnie();
        $form = $this->createForm(CompagnieType::class, $compagnie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke l'image dans la base de données (son nom)
                $img = new Image();
                $img->setName($fichier);
                $compagnie->addImage($img);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compagnie);
            $entityManager->flush();
            $flashy->success('compagnie Ajouter !');
            return $this->redirectToRoute('app_compagnie_index');
        }

            return $this->render('compagnie/new.html.twig', [
            'compagnie' => $compagnie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_compagnie_show", methods={"GET"})
     */
    public function show(NormalizerInterface  $normalizable,Compagnie $compagnie,Request $request): Response
    {
        return $this->render('compagnie/show.html.twig', [
            'compagnie' => $compagnie,
        ]);

    }

    /**
     * @Route("/{id}/edit", name="app_compagnie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Compagnie $compagnie, CompagnieRepository $compagnieRepository,FlashyNotifier  $flashy): Response
    {
        $form = $this->createForm(CompagnieType::class, $compagnie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach((array) $images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // On stocke l'image dans la base de données (son nom)
                $img = new Image();
                $img->setName($fichier);
                $compagnie->addImage($img);
            }

            $this->getDoctrine()->getManager()->flush();
            $flashy->success('compagnie modifier !');

            return $this->redirectToRoute('app_compagnie_index');

        }

        return $this->render('compagnie/edit.html.twig', [
            'compagnie' => $compagnie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_compagnie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Compagnie $compagnie, CompagnieRepository $compagnieRepository): Response
    {
        {
            if ($this->isCsrfTokenValid('delete' . $compagnie->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($compagnie);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_compagnie_index');
        }
    }
    /**
     * @Route("/supprime/image/{id}", name="compagnie_delete_image", methods={"DELETE"})
     */
    public function deleteImage(Image $image, Request $request){
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $image->getName();
            // On supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
    /**
     * @Route("/data/{id}", name="compagnie_data_download", methods={"GET"})
     */
    public function compagnieDataDownload(Compagnie $compagnie)
    {
        // On définit les options du PDF
        $pdfOptions = new Options();
        // Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);

        // On génère le html
        $html = $this->renderView('compagnie/download.html.twig',['compagnie' => $compagnie]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // On génère un nom de fichier
        $fichier = 'compagnie-data-' .'.pdf';

        // On envoie le PDF au navigateur
        $dompdf->stream($fichier, [
            'Attachment' => true
        ]);

        return new Response();
    }


    /**
     * @Route("/get/com", name="categories")
     */
    public function getCompagnies(EntityManagerInterface $em,NormalizerInterface $Normalizer): Response
    {
        $reservation=$em
            ->getRepository(Compagnie::class)
            ->findAll();

        $jsonContent=$Normalizer->normalize($reservation, 'json', ['groups'=>'departement']);
        //dump($json);
        //die;
        return new Response(json_encode($jsonContent));


    }
    /**
     * @Route("/delete/comp/{id}",name="removeCategorie")
     */

    public function removeCompagnie(CompagnieRepository  $compagnieRepository,$id):Response
    {

        $cat=$compagnieRepository->find($id);
        $this->getDoctrine()->getManager()->remove($cat);

        $this->getDoctrine()->getManager()->flush();
        return $this->json(array('title'=>'successful','message'=> "Compagnie supprimé avec succès"),200);

    }
    /**
     * @Route("/addc", name="add_departement", methods={"POST"})
     */
    public function addcomp( NormalizerInterface $normalizable, EntityManagerInterface $entityManager, Request $request)
    {

        $departements = new Compagnie();


        $departements->setCodeIATA($request->get('Code_IATA'));
        $departements->setNomCom($request->get('NomCom'));
        $departements->setNumber($request->get('Number'));
        $departements->setLink($request->get('Link'));
        $departements->setSiege($request->get('Siege'));
        $departements->setAeBase($request->get('AeBase'));
        $departements->setPays($request->get('Pays'));
        $departements->setPassagerNum($request->get('PassagerNum'));
        $departements->setDescription($request->get('Description'));

        $form = $this->createForm(CompagnieType::class, $departements);
        $form->handleRequest($request);
        $images = $form->get('images')->getData();
        foreach((array) $images as $image) {

            $destinationfile = md5(uniqid()) . '.' . $image->guessExtension();
            $img = new Image();



            $destination = $this->getParameter('images_directory') . '/' . $destinationfile;

            copy($img, $destination);

            $departements->addImage($destinationfile);
        }
        $entityManager->persist($departements);
        $entityManager->flush();
        return new JsonResponse([
            'success' => "compagnie has been added"
        ]);
    }
    /**
     * @Route("/edit/comp/{id}",name="editCategorie")
     */

    public function editCategorie(Request $request,CompagnieRepository  $categorieRepository,$id):Response
    {
        $compagnie=$categorieRepository->find($id);
        $compagnie->setCodeIATA($request->get('Code_IATA'));
        $compagnie->setNomCom($request->get('NomCom'));
        $compagnie->setNumber($request->get('Number'));
        $compagnie->setLink($request->get('Link'));
        $compagnie->setSiege($request->get('Siege'));
        $compagnie->setAeBase($request->get('AeBase'));
        $compagnie->setPays($request->get('Pays'));
        $compagnie->setPassagerNum($request->get('PassagerNum'));
        $compagnie->setDescription($request->get('Description'));





        $this->getDoctrine()->getManager()->persist($compagnie);

        $this->getDoctrine()->getManager()->flush();
        return $this->json(array('title'=>'successful','message'=> "Compagnie modifié avec succès"),200);

    }
    /**
     * @Route("/frontC", name="app_compagnie_index_front", methods={"GET"})
     */
    public function indexFront(EntityManagerInterface $entityManager, Request $req, PaginatorInterface $paginator): Response
    {

        $games = $entityManager->getRepository(Compagnie::class)->findAll();

        $pagination = $paginator->paginate(
            $games,
            $req->query->getInt('page', 1),
            6
        );
        return $this->render('compagnie/index_front.html.twig', ['games' => $pagination,]);
    }
}
