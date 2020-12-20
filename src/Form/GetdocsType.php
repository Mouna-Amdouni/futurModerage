<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GetdocsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type',
        ChoiceType::class,array('choices'=>array('Tp'=>'tp','Td'=>'td','Cours'=>'cours','Examens'=>'examens')))

        
        ->add('departement',
        ChoiceType::class,array('choices'=>array('Technologies de l’informatique'=>'ti','Sciences Economiques et Gestion'=>'eg','Génie Électrique'=>'ge','Génie Mécanique'=>'gm','Département Génie Civil'=>'gc')))
        
        
        ->add('Recherche!', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary'
            ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
