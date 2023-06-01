<?php

namespace App\Form;

use App\Entity\ShippingDetails;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('remarks')
            ->add('email')
            ->add('paymentMethod')
            ->add('shippingType');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShippingDetails::class,
        ]);
    }
}
