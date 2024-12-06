<?php

namespace App\Form;

use App\Entity\Yeast;
use App\Entity\YeastStock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YeastStockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('use_by_date', null, [
                'widget' => 'single_text',
            ])
            ->add('weight')
            ->add('remaining_weight')
            ->add('yeast_id', EntityType::class, [
                'class' => Yeast::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => YeastStock::class,
        ]);
    }
}
