<?php

namespace App\Form;

use App\Entity\Debilidad;
use App\Entity\Pokemon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('description', TextareaType::class, [
                'label' => 'Descripción',
                'attr' => [
                    'placeholder' => 'Introduce aquí la descripción del pokemon',
                    'class' => 'miClase'
                ]
            ])
            ->add('image')
            ->add('code')
            ->add('debilidades', EntityType::class, [
                'class' => Debilidad::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false
            ])
            -> add('Enviar', SubmitType::class)
            ->add('Resetear', ResetType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
        ]);
    }
}
