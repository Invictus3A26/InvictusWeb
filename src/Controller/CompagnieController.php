<?php

namespace App\Controller;

use App\Entity\Compagnie;
use App\Entity\Image;
use App\Form\CompagnieType;
use App\Repository\CompagnieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("/compagnie")
 */
class CompagnieController extends AbstractController
{
    /**
     * @Route("/", name="app_compagnie_index", methods={"GET"})
     */
    public function index(CompagnieRepository $compagnieRepository): Response
    {
        return $this->render('compagnie/index.html.twig', [
            'compagnies' => $compagnieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_compagnie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CompagnieRepository $compagnieRepository): Response
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
    public function show(Compagnie $compagnie): Response
    {
        return $this->render('compagnie/show.html.twig', [
            'compagnie' => $compagnie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_compagnie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Compagnie $compagnie, CompagnieRepository $compagnieRepository): Response
    {
        $form = $this->createForm(CompagnieType::class, $compagnie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $images = $form->get('images')->getData();

            // On boucle sur les images
            foreach($images as $image){
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

            return $this->redirectToRoute('app_compagnie_index');

        }

        return $this->render('compagnie/edit.html.twig', [
            'compagnie' => $compagnie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_compagnie_delete", methods={"POST"})
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
     * @Route {"/recherche",name="recherche"}
     */
public function rechercheparcode(Compagnie $compagnie){
        $em=$this->getDoctrine()->getManager();
        $compagnie= $em=$this->getRepository(Compagnie::class)->findAll();
        return $this->render('/compagnie/RechercheCompagnie.html.twig',array('compagnie'=>$compagnie));
}

}
