<?php

namespace App\Form\Validation\Api\App;

use App\DTO\Validation\Api\App\NewFuelTransactionDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NewFuelTransactionDTOType.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class NewFuelTransactionDTOType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('point_of_service', IntegerType::class)
            ->add('pump_number', IntegerType::class)
            ->add('product_code')
            ->add('card', IntegerType::class)
            ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewFuelTransactionDTO::class,
            'csrf_protection' => false,
        ]);
    }
}
