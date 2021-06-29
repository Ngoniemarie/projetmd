<?php

namespace App\Controller;
use App\Entity\Announce;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnnounceRepository;
use Symfony\Component\HttpFoundation\Response;




class HomeController extends AbstractController
{
  
    /**
     * @Route("/anounces", name="app_annouce")
     */
    public function index(AnnounceRepository $repo): Response
    {

        $announces = $repo->findAll();

        return $this->render('anounce/index.html.twig', [

            'announces' => $announces
           
        ]);
    }


    /**
     * @Route("/anounces/{id<[0-9]+>}",name="app_announce_show")
     */

    public function show(AnnounceRepository $repo, int $id): Response
    {
        $announce = $repo->find($id);
        
        return $this->render('anounce/show.html.twig',[
            
            'announce' => $announce
        ]);
    }
   
}

