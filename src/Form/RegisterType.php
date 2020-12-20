<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 
                TextType::class, [
                'required' => true,
                'label' => 'Username',
                'empty_data' => 'Username',
                'attr' => ['class' => 'form-control']
            ])
            ->add('nom', 
                TextType::class, [
                'required' => true,
                'label' => 'nom',
                'empty_data' => 'nom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom', 
                TextType::class, [
                'required' => true,
                'label' => 'prenom',
                'empty_data' => 'prenom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('nce', 
                TextType::class, [
                'required' => true,
                'label' => 'nce',
                'empty_data' => 'nce',
                'attr' => ['class' => 'form-control']
            ])

            ->add('email', 
                EmailType::class, [
                'required' => true,
                'empty_data' => 'example@domain.com',
                'label' => 'Email address',
                'attr' => ['class' => 'form-control']
            ])

            ->add('password', 
                RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'options' => ['attr' => ['class' => 'form-control','pattern' => '{8,10}']],
                'empty_data' => '********',
                'first_options'  => ['label' => 'Define your password'],
                'second_options' => ['label' => 'Confirm your password']
            ])
            ->add('departement',
            ChoiceType::class,array('choices'=>array('Technologies de l’informatique'=>'ti','Sciences Economiques et Gestion'=>'eg','Génie Électrique'=>'ge','Génie Mécanique'=>'gm','Département Génie Civil'=>'gc')))

        ;
    }

}
