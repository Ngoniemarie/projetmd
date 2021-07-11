<?php

namespace App\Controller;

use App\Entity\Announce;
use App\Entity\Comment;
use App\Form\AnnounceType;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnounceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\BrowserKit\Response as BrowserKitResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AnnounceController extends AbstractController
{

    /**
     * @Route("/anounces", name="app_announce_index")
     */
    public function index(AnnounceRepository $repo): Response
    {

        $announces = $repo->findAll();

        return $this->render('anounce/index.html.twig', [

            'announces' => $announces

        ]);
    }


    /**
    * @Route("/annonces/{slug}", name="app_announce_show", requirements={"slug": "[a-z0-9\-]*"})
    * @param Announce $announce
    * @return Response
    */
    public function show(Announce $annonce, Request $request): Response
{


    $comment = new Comment();
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($request);


    if ($form->IsSubmitted() && $form->IsValid()) {
        $em = $this->getDoctrine()->getManager();
        $annonce->addComment( $comment);
        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('app_announce_show', [
             'id' => $annonce->getId(),
             'slug' =>  $annonce->getSlug()
        ]);
    }
    return $this->render('anounce/show.html.twig', [
    'annonce'  => $annonce,
    'form'  => $form->createView()
]);


   // if ($announce->getSlug() !== $slug) {
     //   return $this->redirectToRoute('annonce.show', [
       //     
         //   'slug' => $announce->getSlug()
        //], 301);
    //}
    //return $this->render('anounce/show.html.twig', [
      //  'annonce' => $announce
    //]);

}


    /**
     * @Route("/anounces/create", name="app_announce_create")
     */
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $announce = new Announce();
        $form = $this->createForm(AnnounceType::class, $announce);
        $form->handleRequest($request);

        if ($form->IsSubmitted() && $form->IsValid()) {
            $coverImage = $form->get('coverImage')->getData();

            if ($coverImage) {

                $fichier = md5(uniqid()) . '.' . $coverImage->guessExtension();
                $coverImage->move(
                    $this->getParameter('cover_image_directory'),
                    $fichier
                );
                $announce->setCoverImage($fichier);
            }

            $manager->persist($announce);
            $manager->flush();

            return $this->redirectToRoute('app_announce_index');
        }
        return $this->render('anounce/create.html.twig', [

            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("anounces/{slug}", name="app_announce_edit")
     * @param Announce $announce
     * @param Request $request
     * @return Response
     */
    public function edit(Announce $announce, Request $request)
    {
        $form = $this->createForm(AnnounceType::class, $announce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération de l'image depuis le formulaire
            // dd($request);
            $ImageCover = $form->get('imageCover')->getData();
            if ($ImageCover) {
                //création d'un nom pour l'image avec l'extension récupérée
                $imageName = md5(uniqid()) . '.' . $ImageCover->guessExtension();

                //on déplace l'image dans le répertoire cover_image_directory avec le nom qu'on a crée
                $ImageCover->move(
                    $this->getParameter('cover_image_directory'),
                    $imageName
                );

                // on enregistre le nom de l'image dans la base de données
                $announce->setcoverImage($imageName);
            }
            $this->manager->persist($announce);
            $this->manager->flush();

            return $this->redirectToRoute('app_announce_index');
        }
        

        return $this->render('anounce/edit.html.twig', [
           // 'annonce' => $annonce,
            'form' => $form->createView()
        ]);
    }


     /**
     * @Route("anounces/{slug}/delete", name="app_announce_delete")
     * @param Announce $announce
     * @return RedirectResponse
     */
    public function delete(Announce $announce): RedirectResponse
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($announce);
        $em->flush();

        return $this->redirectToRoute("app_announce_index");
    }
}
