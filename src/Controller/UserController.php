<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;


use App\Entity\User;
use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;
use App\Form\TravilType;
use App\Form\AvatarType;
use App\Form\RegisterType;
use App\Form\ChangePasswordType;
use App\Form\EditProfileDetailsType;

use App\Service\UserFunctions;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;
use Symfony\Component\VarDumper\VarDumper;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index(UserRepository $userRepository)
    {
      
            $users = $userRepository->findAll();
        
           
           
        
        return $this->render('user/index.html.twig', [
            'users' => $users
            
        ]);
    }



    /**
     * @Route("/user/{id}", name="profile", requirements={"id"="\d+"})
     */
    public function profile(User $user = null)
    {
        if (empty($user)) {
            return $this->render('exceptions/404.html.twig', [
                'reason' => 'user'
            ]);
        }
        else {
            return $this->render('user/profile.html.twig', [
                'data' => $user
            ]);
        }
    }

    /**
     * @Route("/editProfile/details/{id}", name="editProfileDetails")
     */
    public function details(User $user, Request $request, EntityManagerInterface $manager ,UserRepository $userRepository)
    {
        if($this->getUser() == $user || $this->isGranted('ROLE_ADMIN')){
            //$x = $userRepository->find($id);
            $form = $this->createForm(EditProfileDetailsType::class, $user);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $x = $this->getUser();
                $x->setBirthDate($form->get('birth_date')->getData());
               

                $manager->persist($x);
                $manager->flush();
    
                return $this->redirectToRoute('profile', array(
                    'id' => $user->getId(),
                ));
            }

            return $this->render('user/editProfileDetails.html.twig', [
                'form'  =>  $form->createView()
            ]);
        }
        else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/editProfile/avatar/{id}", name="changeAvatar")
     */
    public function image(User $user, Request $request, UserFunctions $userFunctions)
    {
        if($this->getUser() == $user || $this->isGranted('ROLE_ADMIN')){
            $form = $this->createForm(AvatarType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $userFunctions->changeAvatar($form->get('file')->getData(),$user);
    
                return $this->redirectToRoute('profile', array(
                    'id' => $this->getUser()->getId(),
                ));
            }

            return $this->render('user/changeimage.html.twig', [
                'form'  =>  $form->createView()
            ]);
        }
        else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/editAccount/password/{id}", name="editPassword")
     */
    public function password(User $user, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder, UserFunctions $userFunctions)
    {
        if($this->getUser() == $user || $this->isGranted('ROLE_ADMIN')){
            $form = $this->createForm(ChangePasswordType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $postPassword = $passwordEncoder->encodePassword($user,$form->get('currentPassword')->getData());

                $oldPassword = $form->get('currentPassword')->getData();

                // ken el mdp l9dima cva
                if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                    
                        $newEncodedPassword = $passwordEncoder->encodePassword($user, $form->get('newPassword')->getData()); 
                        $user->setPassword($newEncodedPassword);
                        $manager->persist($user);
                        $manager->flush();

                        return $this->render('user/changePassword.html.twig');
                    }
                }
                else {                    
                    $form->get('currentPassword')->addError(new FormError("mdp  ghalta"));

                    return $this->render('user/changePassword.html.twig', [
                        'form'  => $form->createView()
                    ]);
                }
            

            return $this->render('user/changePassword.html.twig', [
                'form'  =>  $form->createView()
            ]);
        }
        else {
            return $this->redirectToRoute('home');
        }
    }


  
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

	    $form->handleRequest($request);
	    
	    if($form->isSubmitted() && $form->isValid()){

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->createAvatarFile($form->get('username')->getData());
            $user->setRegistrationDate(date_create(date('Y-m-d')));
            $user->setRoles(['ROLE_ETUD']);
            

	        $em = $this->getDoctrine()->getManager();
	        $em->persist($user);
            $em->flush();
            
          

	        return $this->render('user/registered.html.twig', [
                'user' => $user
            ]);
        }
        else {
            return $this->render('user/register.html.twig', [
                'form' => $form->createView()
            ]);
        }
        
      
    }

 
   /**
     * @Route("/supprofil/{id}", name="supprofil")
     */
    public function supprofil($id,User $user, Request $request,UserRepository $userRepository, EntityManagerInterface $manager, UserFunctions $userFunctions)
    {
        if($this->getUser() == $user || $this->isGranted('ROLE_ADMIN')){
            
            $x = $userRepository->find($id);
            $manager->remove($user);
            $manager->flush();

            return $this->render('home/index.html.twig', [
        
                ]);
            }


            else{
                return $this->render('home/index.html.twig', [
            
                    ]);
                
            }
        }
      
       
}




 
   
