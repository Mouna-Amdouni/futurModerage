<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Actualite;

use App\Repository\ActualiteRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;

use App\Form\StaffManagementType;
class ActualiteController extends AbstractController
{
    /**
     * @Route("/actualite", name="actualite")
     */
    public function index()
    {
        return $this->render('actualite/index.html.twig', [
            'controller_name' => 'ActualiteController',
        ]);
    }


     /**
     * @Route("/act",name="creer_act")
     */
    public function creerAct (Request $requete, EntityManagerInterface $manager){
           $act=new Actualite();
            $act->setCreatedAt(new \DateTime('now'))  ;
        
         $form=$this->createFormBuilder($act)
              
                  ->add('nom', 
                    TextType::class, [
                    'required' => true,
                    'label' => "entrer le sujet d'actualité",
                    'attr' => ['class' => 'form-control']
                ])
           
                  ->add('description', TextareaType::class, [
                    'attr' => [
                        'class' => 'form-control',
                        'rows' => "9", 
                        'cols' => "45"
                    ],
                    'label' => "Decrivez votre sujet"
                ])
                ->add('Valider', SubmitType::class, [
                    'attr' => [
                        'class' => 'btn btn-primary'
                    ]
                ])
                
            ->getForm();
        $form->handleRequest($requete);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($act);
            $manager->flush();
        }
        
        
        
        return $this->render("actualite/index.html.twig", ['formAct'=>$form->createView()]);
        
        
    }
    /**
   * @Route("/acts",name="acts")
     */
public function actualites(){
    $rep=$this->getDoctrine()->getRepository(Actualite::class);
    $acts=$rep->findAll();
    return $this->render('actualite/actualites.html.twig',['acts'=>$acts]);
    
    
    }


    /**
 * @Route("/delete/{id}",name="delete")

 */
public function deleteact($id){
    $entityManager=$this->getDoctrine()->getManager();
    $act=$entityManager->getRepository(Actualite::class)->find($id);
    $entityManager->remove($act);
    $entityManager->flush();
    return $this->redirectToRoute('acts');

}
 /**
 * @Route("/detailact/{id}",name="detailact")

 */
public function detailact($id){
    $rep=$this->getDoctrine()->getRepository(Actualite::class);
    $act=$rep->find($id);
    return $this->render('actualite/detailact.html.twig',['act'=>$act]);
    
    
  

}
/**
 * @Route("/editer/{id}",name="editer")
 */
public function editer(Actualite $act=null,Request $requete,EntityManagerInterface $manager){
    if(!$act){
        $act =new Actualite();
    }
        $form=$this->createFormBuilder($act)
        ->add('nom', 
        TextType::class, [
        'required' => true,
        'label' => "entrer le sujet d'actualité",
        'attr' => ['class' => 'form-control']
    ])

      ->add('description', TextareaType::class, [
        'attr' => [
            'class' => 'form-control',
            'rows' => "9", 
            'cols' => "45"
        ],
        'label' => "Decrivez votre sujet"
    ])
            ->add('Enregistrer Les Modifier', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        $form->handleRequest($requete);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($act);
            $manager->flush();
    
    
        }
        return $this->render("actualite/editer.html.twig", ['formAct'=>$form->createView()]);
    }

  

  } 


  