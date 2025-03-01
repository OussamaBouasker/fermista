<?php

namespace App\Form;

use App\Entity\Livraison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
<<<<<<< HEAD
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType; 
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
=======
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD
        ->add('Date', null, [
            'widget' => 'single_text',
        ])
            
            ->add('lieu', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez le lieu']
=======
            ->add('Date', null, [
                'widget' => 'single_text',
            ])
            ->add('Heure', null, [
                'widget' => 'single_text',
>>>>>>> 7c535b1bed9f0b42015bf80bdc2d087f96aa8d3f
            ])
            ->add('Livreur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
