<?php

namespace App\Form;

use App\Entity\Brew;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('save', SubmitType::class, ['label' => 'Brew'])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->setDefaults(...))
            ->addEventListener(FormEvents::POST_SUBMIT, $this->setTimestamps(...))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Brew::class,
        ]);
    }
    public function setDefaults(PreSubmitEvent $event): void
    {
        $data = $event->getData();
        if (!$data['type']) {
            $data['type'] = $data['name'];
        }
        $event->setData($data);
    }

    public function setTimestamps(PostSubmitEvent $event): void
    {
        $data = $event->getData();
        $datetime = new \DateTimeImmutable();
        $data->setUpdatedAt($datetime);
        if (!$data->getId()) {
            $data->setCreatedAt($datetime);
        }
    }
}
