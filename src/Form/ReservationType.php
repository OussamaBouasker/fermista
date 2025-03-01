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
<<<<<<< HEAD
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD
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
                'choice_attr' => function ($choice, $key, $value) {
                    // Vous pouvez utiliser des classes CSS ou des styles en ligne
                    switch ($value) {
                        case 'canceled':
                            return ['class' => 'text-orange'];
                        case 'confirmed':
                            return ['class' => 'text-success'];
                        case 'pending':
                            return ['class' => 'text-warning'];
                        default:
                            return [];
                    }
                },
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
            ->add('workshop', EntityType::class, [
                'class' => Workshop::class,
                'choice_label' => 'titre', // or another property you want to display
                // 'disabled' => true,        // remove or set to false if you want it editable
                // Remove 'mapped' => false if the relation is already defined in your entity
            ])
            // Ajoutez le champ 'nbr_places_a_reserver' pour les places réservées
            // ->add('nbr_places_a_reserver', IntegerType::class, [
            //     'label' => 'Nombre de places à réserver',
            //     'required' => true,
            //     'attr' => ['placeholder' => 'Entrez le nombre de places à réserver'],
            // ])




=======
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
            ->add('workshop', EntityType::class, [
                'class' => Workshop::class,
                'choice_label' => 'titre',
            ])
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
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
