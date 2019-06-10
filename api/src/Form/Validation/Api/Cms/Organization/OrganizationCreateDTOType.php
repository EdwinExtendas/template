<?php

namespace App\Form\Validation\Api\Cms\Organization;

use App\DTO\Validation\Api\Cms\Organization\OrganizationCreateDTO;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class OrganizationDTO.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class OrganizationCreateDTOType extends OrganizationEditDTOType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user_client_id')
            ->add('client_id')
            ->add('client_secret')
            ->add('grant_type')
        ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrganizationCreateDTO::class,
            'csrf_protection' => false,
        ]);
    }
}
