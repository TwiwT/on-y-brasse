<?php

namespace App\Form;

use App\Entity\Brew;
use App\Entity\BrewMashing;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrewMashingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duration')
            ->add('details')
            ->add('water')
            ->add('water_rinsing')
            ->add('brew_id', EntityType::class, [
                'class' => Brew::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BrewMashing::class,
        ]);
    }
}
