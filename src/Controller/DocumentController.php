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
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
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
use App\Entity\Document;
use App\Repository\TravailRepository;
use App\Repository\DocumentRepository;
use App\Form\AjouterdocType;
use App\Form\GetdocsType;


class DocumentController extends AbstractController
{
   /**
     * @Route("/deposer", name="deposer")
     */
    public function deposer(  Request $request, EntityManagerInterface $manager,UserFunctions $userFunctions,UserRepository $UserRepository)
    {
      if($this->getUser() ) {
      $form = $this->createForm(AjouterdocType::class);
      $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
           $userFunctions->uploaddoc2($form->get('nomdoc')->getData(),$this->getUser(),$form->get('document')->getData());
           $Document = new Document();
           $Document->setNomdoc($form->get('nomdoc')->getData()); 
           $Document->setCreatedat( new \DateTime('now')); 
           $Document->setType($form->get('type')->getData()); 
           $Document->setDepartement($form->get('departement')->getData());
           $Document->setIdEns($this->getUser()->getId()); 
          
           $manager->persist($Document);
           $manager->flush();

                return $this->render('document/ajoutdoc.html.twig', [
                  'form'  =>  $form->createView()
              ]);
         }

        return $this->render('document/ajoutdoc.html.twig', [
            'form'  =>  $form->createView()
        ]);
    //}
    //else {
  //     return $this->redirectToRoute('home');
  //  }
  }
  }

/**
     * @Route("/document", name="document")
     */
    public function document(  Request $request, EntityManagerInterface $manager,DocumentRepository $documentRepository)
    { 
      if($this->getUser() ) {
        $form = $this->createForm(GetdocsType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        $documents = $documentRepository->getdocs($form->get('type')->getData(),$form->get('departement')->getData());
        return $this->render('document/resultatdoc.html.twig', [
         'documents'=>$documents,
      ]);
        
           }
         }



         return $this->render('document/tridoc.html.twig', [
        
          'form'  =>  $form->createView()
      ]);
    
    }

  /**
 * @Route("/Teledoc/{id}", name="Teledoc")
  **/
  public function downloadFileAction(Document $document ){
    $filename = $document->getIdEns().$document->getNomdoc().'.pdf';
    $response = new BinaryFileResponse( "./doc2/$filename");
    $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT,'pdf.pdf');
    return $response;
  }

    /**
 * @Route("/deletedocc/{id}",name="deletedocc")

 */
public function deletedoc($id){
  $entityManager=$this->getDoctrine()->getManager();
  $doc=$entityManager->getRepository(Document::class)->find($id);
  $entityManager->remove($doc);
  $entityManager->flush();
  return $this->redirectToRoute('document');

}










}
