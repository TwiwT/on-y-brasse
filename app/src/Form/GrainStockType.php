<?php

namespace App\Form;

use App\Entity\Grain;
use App\Entity\GrainStock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrainStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bought_at', null, [
                'widget' => 'single_text',
            ])
            ->add('weight')
            ->add('remaining_weight')
            ->add('grain_id', EntityType::class, [
                'class' => Grain::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GrainStock::class,
        ]);
    }
}
