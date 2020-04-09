<?php

namespace App\Form;

use App\Entity\Carrousel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarrouselType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', ChoiceType::class,[
                'choices' => $this->getChoice()
            ])
            ->add('ImageFile', FileType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Carrousel::class,
        ]);
    }

    private function getChoice(): array
    {
        $choices = Carrousel::TITLE;
        $outpout= [];
        foreach ($choices as $k => $v){
            $outpout[$v] = $k;
        }
        return $outpout;
    }
}
