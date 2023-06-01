<?php

namespace App\Form;

use App\Entity\ShippingDetails;
use App\Entity\ShippingType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShippingDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('name')
            ->add('street')
            ->add('buildingNumber')
            ->add('apartment')
            ->add('postalCode')
            ->add('city')
            ->add('phoneNr')
            ->add('email')
            ->add('paymentMethod', null, [
                'attr' => ['style' => 'width: 100%'],
            ])
            ->add('shippingType', EntityType::class, [
                'class' => ShippingType::class,
                'choice_label' => function ($shippingType) {
                    $price = number_format($shippingType->getPrice(), 2, '.', '');
                    return $shippingType->getType() . ' - ' . $price . ' PLN';
                },
                'label' => 'Shipping type',
                'attr' => ['style' => 'width: 100%'],
            ])
            ->add('remarks', TextareaType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShippingDetails::class,
        ]);
    }
}
