<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
class EditProfileDetailsType extends AbstractType
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

            

    ->add('birth_date', DateType::class, [
             'widget' => 'single_text',
             
                'format' => 'yyyy-MM-dd',
                'label' => 'Date de naissance(YYYY-MM-DD)',
                'attr' => [
                    'class' => 'form-control'
                ],
                'required'   => false,
                'empty_data' => ''
            ])


            ->add('Confirm profile details', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}


