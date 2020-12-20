<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null,['label'=>'Nom :  '])
            ->add('prenom',null,['label'=>'Prénom:  '])
            ->add('adresse',null,['label'=>'Votre adresse :  '])
            
            ->add('email',EmailType::class,['label'=>'Votre e-mail :  '])
            ->add('motDePasse',PasswordType::class,['label'=>'Mot de passe :  '])
            ->add('cin',null,['label'=>'Votre CIN :  '])
            ->add('tel',TelType::class,['label'=>'Votre numéro de téléphone :  '])
            ->add('dateNaissance',DateType::class,[
                'widget' => 'single_text',
                 'format' => 'yyyy-MM-dd'
            ], ['label'=>'Date de naissance :  '])
            ->add('genre',ChoiceType::class,array(
                'choices'=>array('Homme'=>true,'Femme'=>false)
            ),['label'=>'Genre :  '])
            ->add('save_enqueteur', SubmitType::class,[
                'label'=>'en tant que enqueteur'
            ])
            ->add('save_sonde', SubmitType::class,[
                'label'=>'en tant que sonde'
            ])
            ->add('photo',FileType::class, array('data_class' => null))
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
    /*
    public count($i,$f){
        $a=[];
        while($i<$f){

        }
    }*/
}
