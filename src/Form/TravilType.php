<?php

namespace App\Form;

use App\Entity\Travail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class TravilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('Nomdoc',
            TextType::class, [
            'required' => true,
            'label' => 'le nom de votre travail/projet',
            'attr' => ['class' => 'form-control']
    ])
 

            ->add('document', FileType::class, [
                'required' => true,
                'label' => 'deposer votre travail | Max : 20 MB',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true
        ]);
    }
}
