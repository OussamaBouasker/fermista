<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\RapportMedical;
<<<<<<< HEAD
use App\Entity\Vache;
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
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
<<<<<<< HEAD
            ->add('vache', EntityType::class, [
                'class' => Vache::class,
                'choice_label' => 'id',

            ])
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
        ]);
    }
}
