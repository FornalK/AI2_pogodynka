<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Measurment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date')
            ->add('temperature')
            ->add('wind')
            ->add('cloudiness_level')
            ->add('city', EntityType::class, [
                'class' => City::class,
                'mapped' => true,
                'choice_label' => 'city_name',
                'choice_value' => 'id'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurment::class,
        ]);
    }
}
