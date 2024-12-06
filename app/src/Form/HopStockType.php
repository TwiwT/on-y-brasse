<?php

namespace App\Form;

use App\Entity\Hop;
use App\Entity\HopStock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HopStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bought_at', null, [
                'widget' => 'single_text',
            ])
            ->add('weight')
            ->add('remaining_weight')
            ->add('hop_id', EntityType::class, [
                'class' => Hop::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HopStock::class,
        ]);
    }
}
