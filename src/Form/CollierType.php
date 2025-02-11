<?php

namespace App\Form;

use App\Entity\Collier;
use App\Entity\Vache;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference')
            ->add('taille')
            ->add('valeurTemperature')
            ->add('valeurAgitation')
            ->add('vache', EntityType::class, [
                'class' => Vache::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Collier::class,
        ]);
    }
}
