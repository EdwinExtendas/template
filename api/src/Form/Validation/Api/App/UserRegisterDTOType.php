<?php

namespace App\Form\Validation\Api\App;

use App\DTO\Validation\Api\App\UserRegisterDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserFormType.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class UserRegisterDTOType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array                                        $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('api_code')
            ->add('email')
            ->add('phone_number')
            ->add('pan')
            ->add('card_number')
            ;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRegisterDTO::class,
            'csrf_protection' => false,
        ]);
    }
}
