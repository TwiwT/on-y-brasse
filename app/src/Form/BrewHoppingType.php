<?php

namespace App\Form;

use App\Entity\Brew;
use App\Entity\BrewHopping;
use App\Entity\Hop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrewHoppingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('weight')
            ->add('add_at')
            ->add('sort')
            ->add('brew_id', EntityType::class, [
                'class' => Brew::class,
                'choice_label' => 'id',
            ])
            ->add('hop_id', EntityType::class, [
                'class' => Hop::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BrewHopping::class,
        ]);
    }
}
