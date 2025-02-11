<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Workshop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reservation_date', null, [
                'widget' => 'single_text',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Pending' => 'pending',
                    'Confirmed' => 'confirmed',
                    'Canceled' => 'canceled',
                ],
                'expanded' => false,  // Set to true for radio buttons instead of a dropdown
                'multiple' => false,  // Ensure only one option can be selected
            ])
            ->add('prix')
            ->add('commentaire')
            ->add('confirmation')
            ->add('workshop', EntityType::class, [
                'class' => Workshop::class,
                'choice_label' => 'titre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
