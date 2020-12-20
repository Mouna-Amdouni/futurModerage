<?php

namespace App\Form;

use App\Entity\Document;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class AjouterdocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nomdoc',
        TextType::class, [
        'required' => true,
        'label' => 'le nom de votre document',
        'attr' => ['class' => 'form-control']
])
            
            
            ->add('type',
            ChoiceType::class,array('choices'=>array('Tp'=>'tp','Td'=>'td','Cours'=>'cours','Examens'=>'examens')))

            
            
            ->add('departement',
            ChoiceType::class,array('choices'=>array('Technologies de l’informatique'=>'ti','Sciences Economiques et Gestion'=>'eg','Génie Électrique'=>'ge','Génie Mécanique'=>'gm','Département Génie Civil'=>'gc')))

            ->add('document', FileType::class, [
                'required' => true,
                'label' => 'deposer le document | Max : 20 MB',
                'attr' => [
                    'class' => 'form-control',
                    'accept' => ".pdf"
                ]
            ])
            ->add('Déposer!', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            
        ]);
    }
}
