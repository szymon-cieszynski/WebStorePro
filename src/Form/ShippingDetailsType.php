<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\ShippingDetails;
use App\Entity\ShippingType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            ->add('postalCode', TextType::class, [
                'attr' => [
                    'pattern' => '\d{2}-\d{3}',
                    'title' => 'Enter a postal code in the format XX-XXX'
                ]
            ])
            ->add('city')
            ->add('phoneNr')
            ->add('email')
            ->add('paymentMethod', null, [
                'attr' => ['class' => 'custom-select'],
                'placeholder' => 'Choose payment method'
            ])
            ->add('shippingType', EntityType::class, [
                'class' => ShippingType::class,
                'choice_label' => function ($shippingType) {
                    $price = number_format($shippingType->getPrice(), 2, '.', '');
                    return $shippingType->getType() . ' - ' . $price . ' PLN';
                },
                'label' => 'Shipping type',
                'attr' => ['class' => 'custom-select'],
                'placeholder' => 'Choose your courier',
                'choice_value' => function ($shippingType) {
                    return $shippingType ? $shippingType->getId() . '|' . $shippingType->getPrice() : '';
                }
            ])
            ->add('remarks', TextareaType::class, [
                'attr' => [
                    'required' => false
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShippingDetails::class,
        ]);
    }
}
