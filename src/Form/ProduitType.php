<?php

namespace App\Form;
<<<<<<< HEAD

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Commande;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
=======
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Produit;
use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    {
        $builder
            ->add('Nom')
            ->add('Prix')
<<<<<<< HEAD
            ->add('Etat', ChoiceType::class, [
                'choices' => [
                    'Frais' => 'Frais',
                    'Périmé' => 'Périmé',
                    'À consommer bientôt' => 'À consommer bientôt',
                    'Non réfrigéré' => 'Non réfrigéré',
                ],
                'placeholder' => 'Choisir l\'état du produit',
            ])
            ->add('Description')
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Lait' => 'Lait',
                    'Fromage' => 'Fromage',
                    'Yaourt' => 'Yaourt',
                    'Beurre' => 'Beurre',
                    'Crème-fraiche' => 'Crème-fraiche',
                ],
                'placeholder' => 'Choisir la catégorie',
            ])
            ->add('commande', EntityType::class, [
                'class' => Commande::class,
                'choice_label' => 'id',
                'label' => 'Commande associée',
            ])
            ->add('image', FileType::class, [
                'label' => 'Image du produit',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/jpg', 'image/gif'],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (jpeg, gif, jpg).',
                    ])
                ],
            ]);
    }
}
=======
            ->add('Etat')
            ->add('Description')
            ->add('categorie')
            ->add('commande', EntityType::class, [
                'class' => Commande::class,
                'choice_label' => 'id',

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
