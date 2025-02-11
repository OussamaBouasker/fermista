<?php

namespace App\Form;

use App\Entity\RapportMedical;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportMedicalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num')
            ->add('race')
            ->add('historique_de_maladie')
            ->add('cas_medical')
            ->add('solution')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RapportMedical::class,
        ]);
    }
}
