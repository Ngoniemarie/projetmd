<?php

namespace App\Controller;
use App\Entity\Announce;
use App\Form\AnnounceType;
use App\Repository\AnnounceRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AdminController extends AbstractController
{   
   



    private $repository;

    /**
    * var AnnounceRepository
    */
    public function __construct(AnnounceRepository $repo)
    {
        $this->repository = $repo;
    }

    
 
    /**
     * @Route("annonces/admin", name="app_announce_admin")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $annonces = $this->repository->findAll();
        return ($this->render('home/index_.html.twig', compact('annonces')));

        
    }
}
