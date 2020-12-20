<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManagerInterface;

use App\Form\StaffManagementType;

class ManagementController extends AbstractController
{
    /**
     * @Route("/management", name="management")
     */
    public function management()
    {
        if($this->getUser() && $this->isGranted('ROLE_ENSE')) {
            return $this->render('management/index.html.twig');
        }   
        else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/management/staff", name="staff_management")
     */
    public function staffManagement(Request $request, UserRepository $userRepository, EntityManagerInterface $manager)
    {
        $form = $this->createForm(StaffManagementType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
         
            if ($form->get('moins')->isClicked()){
                if($form->get('user')->getData()->getRoles() == ["ROLE_ETUD","ROLE_ENSE","ROLE_ADMIN"]) {
                    $callback = 'ERREUR: ADMIN ne peut pas modifier sa  positiondans le site';
                }
                else if($form->get('user')->getData()->getRoles() == ["ROLE_ETUD"]) {
                    $callback = 'ERROR : '.$form->get('user')->getData()->getUsername().' est déjà un utilisateur';
                }
                else {
                    $form->get('user')->getData()->setRoles(['ROLE_ETUD']);
                    $manager->flush();
                    $callback = $form->get('user')->getData()->getUsername(). ' is demoted';
                }
            }
            

            else if($form->get('plus')->isClicked()) {
                if($form->get('user')->getData()->getRoles() == ["ROLE_ETUD","ROLE_ENSE","ROLE_ADMIN"]) {
                    $callback = 'ERREUR: ADMIN ne peut pas modifier sa  positiondans le site';
                }
                else if($form->get('user')->getData()->getRoles() == ["ROLE_ETUD","ROLE_ENSE"]) {
                    $callback = 'ERROR : '.$form->get('user')->getData()->getUsername().' est déjà enseignant ';
                }
                else {
                    $form->get('user')->getData()->setRoles(['ROLE_ETUD','ROLE_ENSE']);
                    $manager->flush();
                    $callback = $form->get('user')->getData()->getUsername(). ' est devenu enseignant';
                }
            }
           

            
            
            $users = $userRepository->getFullUserByRole('"ROLE_ETUD"');

            
            return $this->render('management/staffManagement.html.twig', [
                
                'users' => $users,
                'form'  => $form->createView(),
                'results' => $callback
            ]);
        }
        else {
            
            $staff = $userRepository->getFullUserByRole('"ROLE_ENSE"');
            $users = $userRepository->getFullUserByRole('"ROLE_ETUD"');

            return $this->render('management/staffManagement.html.twig', [
                'staff' => $staff,
                'users' => $users,
                'form'  => $form->createView()
            ]);
        }
    }
}
