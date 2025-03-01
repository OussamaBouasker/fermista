<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\RapportMedical;
use App\Entity\Vache;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('heure', null, [
                'widget' => 'single_text',
            ])

            ->add('lieu')
            ->add('rapportmedical', EntityType::class, [
                'class' => RapportMedical::class,
                'choice_label' => 'id',

            ])
            ->add('vache', EntityType::class, [
                'class' => Vache::class,
                'choice_label' => 'id',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
