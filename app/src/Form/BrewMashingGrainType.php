<?php

namespace App\Form;

use App\Entity\BrewMashing;
use App\Entity\BrewMashingGrain;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrewMashingGrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('weight')
            ->add('mashing_id', EntityType::class, [
                'class' => BrewMashing::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BrewMashingGrain::class,
        ]);
    }
}
