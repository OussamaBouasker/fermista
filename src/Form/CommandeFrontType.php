<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeFrontType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom Complet',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez votre nom'],
            ])
            ->add('email', null, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez votre email'],
            ])
            ->add('localisation', null, [
                'label' => 'Localisation',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Cliquez sur la carte pour définir votre localisation',
                    'data-map' => true, // Cette option pour la carte, si nécessaire
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Utilisation de stdClass au lieu de l'entité
        $resolver->setDefaults([
            'data_class' => \stdClass::class, // Utilisation d'un objet PHP classique
        ]);
    }
}
