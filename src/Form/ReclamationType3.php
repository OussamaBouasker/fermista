<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Reclamation;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;


class ReclamationType3 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $badWords = ['fuck', 'shit', 'puta','bitch', 'asshole', 'damn', 'bastard']; // Liste des gros mots interdits

        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'constraints' => [
                    new Assert\Callback(function ($value, $context) use ($badWords) {
                        foreach ($badWords as $word) {
                            if (stripos($value, $word) !== false) {
                                $context->buildViolation('La description contient un mot interdit : "' . $word . '".')
                                    ->addViolation();
                                return;
                            }
                        }
                    }),
                ],
            ]);
    }

   

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
