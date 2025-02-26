<?php

namespace App\Form;

use App\Entity\Workshop;
use Proxies\__CG__\App\Entity\Workshop as EntityWorkshop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class WorkshopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'attr' => ['class' => 'datetime-picker'],
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Atelier Live' => 'Atelier Live',
                    'Formation Autonome' => 'Formation Autonome',
                ],
                'expanded' => false, // false = dropdown, true = boutons radio
                'multiple' => false, // false = une seule option possible
                'attr' => ['class' => 'form-control'], // Pour le styling Bootstrap
                'placeholder' => 'Sélectionnez un type',
            ])
            ->add('prix')
            ->add('theme')
            ->add('duration', TimeType::class, [
                'widget'   => 'single_text',
                'required' => true, // pour forcer la saisie
            ])            ->add('nbrPlacesMax', IntegerType::class, [
                'label' => 'Nombre maximum de places',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (JPG, PNG, WEBP)',
                'mapped' => false, // Important: Do not map directly to entity
                'required' => true, // Make it optional
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/webp'],
                        'mimeTypesMessage' => 'Please upload a valid image (JPEG, PNG, WEBP)',
                    ])
                ],
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workshop::class, // Correct class reference
        ]);
    }
}
