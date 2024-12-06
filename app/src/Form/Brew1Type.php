<?php

namespace App\Form;

use App\Entity\Brew;
use App\Entity\BrewBoiling;
use App\Entity\BrewBottling;
use App\Entity\BrewFermentation;
use App\Entity\BrewMashing;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Brew1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('created_at', null, [
                'widget' => 'single_text',
            ])
            ->add('updated_at', null, [
                'widget' => 'single_text',
            ])
            ->add('type')
            ->add('target_volume')
            ->add('alcool')
            ->add('density_initial')
            ->add('density_final')
            ->add('mashing', EntityType::class, [
                'class' => BrewMashing::class,
                'choice_label' => 'id',
            ])
            ->add('boiling', EntityType::class, [
                'class' => BrewBoiling::class,
                'choice_label' => 'id',
            ])
            ->add('fermentation', EntityType::class, [
                'class' => BrewFermentation::class,
                'choice_label' => 'id',
            ])
            ->add('bottling', EntityType::class, [
                'class' => BrewBottling::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Brew::class,
        ]);
    }
}
