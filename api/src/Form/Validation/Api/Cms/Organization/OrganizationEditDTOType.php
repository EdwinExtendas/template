<?php

namespace App\Form\Validation\Api\Cms\Organization;

use App\DTO\Validation\Api\Cms\Organization\OrganizationEditDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OrganizationEditDTOType.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class OrganizationEditDTOType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('fo_api_code')
            ->add('payment_type')
        ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrganizationEditDTO::class,
            'csrf_protection' => false,
        ]);
    }
}
