<?php

namespace App\Form;

use App\Entity\Brew;
use App\Entity\BrewBottling;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrewBottlingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sugar')
            ->add('details')
            ->add('final_volume')
            ->add('brew_id', EntityType::class, [
                'class' => Brew::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BrewBottling::class,
        ]);
    }
}
