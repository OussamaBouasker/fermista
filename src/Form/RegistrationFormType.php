<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password', PasswordType::class, [
            'mapped' => true, // This prevents Symfony from trying to set it directly on the entity
            'required' =>false,
        ])
       
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
        
        
        ->add('roles', ChoiceType::class, [
            'label' => 'Choisissez votre rôle',
            'choices' => [
                
                'Agriculteur' => 'ROLE_AGRICULTOR',
                'Vétérinaire' => 'ROLE_VETERINAIR',
                'Client' => 'ROLE_CLIENT',
                'Formateur' => 'ROLE_FORMATEUR',
            ],
            'expanded' => false, // Dropdown menu
            'multiple' => false, // Ensure single selection
            'required' => true, // Mandatory field
            'mapped'   => false , // Prevent Symfony from directly setting it
            'attr' => [
                'class' => 'block w-full p-3 border border-gray-300 rounded-md text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500'
            ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Photo de profil (JPG ou PNG)',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Veuillez télécharger une image JPG ou PNG valide',
                    ]),
                ],
            ])
            ->add('captcha', CaptchaType::class, [
                'width' => 200,
                'height' => 50,
                'length' => 6,
                'attr' => ['class' => 'common__login__input']
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_edit' => false,
]);
    }
}
