<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Enum\EnumRole;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',


            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',

            ])
            ->add('number', TelType::class, [
                'label' => 'Numéro de téléphone',

            ])
            ->add('email', TextType::class)

            ->add('password', PasswordType::class, [
                'mapped' => true, // This prevents Symfony from trying to set it directly on the entity
                'required' => false,
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Choisissez votre rôle',
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Agriculteur' => 'ROLE_AGRICULTOR',
                    'Vétérinaire' => 'ROLE_VETERINAIR',
                    'Client' => 'ROLE_CLIENT',
                    'Formateur' => 'ROLE_FORMATEUR',
                ],
                'expanded' => false, // Dropdown menu
                'multiple' => false, // Ensure single selection
                'required' => true, // Mandatory field
                'mapped'   => false, // Prevent Symfony from directly setting it
                'attr' => [
                    'class' => 'block w-full p-3 border border-gray-300 rounded-md text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_edit' => false, // Définit si c'est une édition ou une création
        ]);
    }
}
