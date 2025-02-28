<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Workshop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reservation_date', HiddenType::class, [
                'disabled' => true, // Make it read-only
                'mapped' => false, // We handle this manually
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Canceled'  => 'canceled',
                    'Confirmed' => 'confirmed',
                    'Pending'   => 'pending',
                ],
                'data' => 'pending', // Set default value
                'expanded' => false,  // Show as a dropdown
                'required' => true,
                'label' => 'Statut de la réservation',
            ])

            ->add('prix', HiddenType::class, [
                'disabled' => true, // Make it read-only
                'mapped' => false, // We handle this manually
            ])

            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Adresse Email',
                'attr' => ['placeholder' => 'exemple@email.com'],
            ])
            ->add('num_tel', IntegerType::class, [
                'required' => true,
                'label' => 'Numéro de Téléphone',
                'attr' => ['placeholder' => 'Entrez votre numéro'],
            ])

            ->add('num_carte_bancaire', TextType::class, [
                'label' => 'Numéro de carte bancaire',
                'required' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('commentaire')
            ->add('workshop', HiddenType::class, [
                'mapped' => false, // We will set this manually in the controller
                // or another property you want to display
                // 'disabled' => true,        // remove or set to false if you want it editable
                // Remove 'mapped' => false if the relation is already defined in your entity
            ])
            // Ajoutez le champ 'nbr_places_a_reserver' pour les places réservées
            // ->add('nbr_places_a_reserver', IntegerType::class, [
            //     'label' => 'Nombre de places à réserver',
            //     'required' => true,
            //     'attr' => ['placeholder' => 'Entrez le nombre de places à réserver'],
            // ])




            ->add('confirmation', CheckboxType::class, [
                'required' => true, // Allow the checkbox to be unchecked
                'label' => 'Accepter le reglement des workshops',
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
