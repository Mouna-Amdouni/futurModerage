<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnqueteurController extends AbstractController
{
   
    /**
     * @Route("/enqueteur/contoller", name="enqueteur_contoller")
     */
    public function index(): Response
    {
        return $this->render('Enqueteur/index.html.twig', [
            'controller_name' => 'EnqueteurContollerController',
        ]);
    }
    /**
     * @Route("/utilisateur/inscription/{id}",name="addEnqueteur")
     */
    public function ajoutEnqueteur($id,Request $req){
        $this->render('Enqueteur/inscription.html.twig',['em'=>$id->getId()]);
    }
}

