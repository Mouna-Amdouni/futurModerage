<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Entity\User;
use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;

use App\Form\TravilType;
use App\Form\AvatarType;
use App\Form\RegisterType;
use App\Form\ChangePasswordType;
use App\Form\EditProfileDetailsType;
use App\Form\CorrigerdocType;
use App\Service\UserFunctions;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use App\Entity\Travail;
use App\Repository\TravailRepository;

class TravaillController extends AbstractController
{
    /**
     * @Route("/travaill", name="travaill")
     */
    public function index(  Request $request, EntityManagerInterface $manager,UserFunctions $userFunctions)
    {
      if($this->getUser() ) {
      $form = $this->createForm(TravilType::class);
      $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
          $userFunctions->uploaddoc($form->get('document')->getData(),$this->getUser(),$form->get('Nomdoc')->getData());
           $travail = new Travail();
           $travail->setNomdoc($form->get('Nomdoc')->getData()); 
           $travail->setIdetudiant($this->getUser()->getId()); 

           $manager->persist($travail);
                $manager->flush();

                return $this->render('travaill/index.html.twig', [
                  'form'  =>  $form->createView()
              ]);
         }

        return $this->render('travaill/index.html.twig', [
            'form'  =>  $form->createView()
        ]);
    //}
    //else {
  //     return $this->redirectToRoute('home');
  //  }
  }
  }
/**
     * @Route("/corriger", name="corriger")
     */
    public function corriger(  Request $request, EntityManagerInterface $manager,TravailRepository $travailRepository)
    { 
      if($this->getUser() && $this->isGranted('ROLE_ENSE')) {
      $travails = $travailRepository->gettravail($this->getUser()->getDepartement());

         }



         return $this->render('travaill/corriger.html.twig', [
          'travails' => $travails,
          //'form'  =>  $form->createView()
      ]);
    
    }
    /**
     * @Route("/docs", name="docs")
     */
    public function docs(  Request $request, EntityManagerInterface $manager,TravailRepository $travailRepository)
    { 
      if($this->getUser() && $this->isGranted('ROLE_ETUD')) {
      $travails = $travailRepository->gettravailperso($this->getUser()->getId());

         }
         
         return $this->render('travaill/documents.html.twig', [
          'travails' => $travails,
          //'form'  =>  $form->createView()
      ]);
    
    }


    /**
     * @Route("/evaluer/{id}", name="evaluation")
     */
    public function evaluer( Travail $travail , TravailRepository $travailRepository, Request $request, EntityManagerInterface $manager)
    { 
          $form = $this->createForm(CorrigerdocType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                  $travail->setIdEnseignant($this->getUser()->getId());
                  $travail->setRemarque($form->get('Remarque')->getData());
                  $manager->persist($travail);
                  $manager->flush();

            }

  

         return $this->render('travaill/evaluer.html.twig', [
          'travail'=>$travail,
         'form'  =>  $form->createView()
      ]);
    
    }

 /**
 * @Route("/download/{id}", name="download_file")
  **/
      public function downloadFileAction(Travail $travail ){
        $filename = $travail->getIdetudiant().$travail->getNomdoc().'.pdf';
        $response = new BinaryFileResponse( "./doc/$filename");
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT,'pdf.pdf');
        return $response;
      }


  }
  
      