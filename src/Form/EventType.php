<?php

namespace App\Form;

use App\Entity\Event;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options: [
                'label' => 'Nom'
            ])
            ->add('description')
            ->add('price', options: [
                'label' => 'Prix'
            ])
            ->add('released_at', options: [
                'label' => 'Commence le',
                'years' => range(2022, 2032)
            ])
            ->add('finished_at', options: [
                'label' => 'Termine le',
                'years' => range(2022, 2032)
            ])
            ->add('image')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
