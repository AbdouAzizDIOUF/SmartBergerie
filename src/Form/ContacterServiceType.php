<?php

namespace App\Form;

use App\Entity\ContacterService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContacterServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', TextType::class)
            ->add('Prenom', TextType::class)
            ->add('Telephone', TextType::class)
            ->add('Email', EmailType::class)
            ->add('Message', TextareaType::class,[
                'attr' =>[
                    'id' => 'exampleFormControlTextarea5',
                    'placeholder' => 'Saisissez votre message',
                    'rows' => 5
                ]
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContacterService::class
        ]);
    }

}