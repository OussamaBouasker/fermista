<?php

namespace App\Form;

use App\Entity\Vache;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
<<<<<<< HEAD
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f

class VacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD
            ->add('name', TextType::class)
            ->add('age', IntegerType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Entrez l\'âge de la vache'],
            ])
            ->add('race', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Entrez la race de la vache'],
            ])
            ->add('EtatMedical', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Entrez l\'état médical de la vache'],
            ]);
=======
            ->add('age')
            ->add('race')
            ->add('EtatMedical')
        ;
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vache::class,
        ]);
    }
}
