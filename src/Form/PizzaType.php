<?php

declare(strict_types=1);

namespace App\Form;

use App\Dto\PizzaBaseDto;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PizzaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom de la pizza'
            ])
            ->add('price', null, [
                'label' => 'Prix'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PizzaBaseDto::class,
        ]);
    }
}
