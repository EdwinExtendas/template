<?php

namespace App\DTO\Validation\Api\Cms\Organization;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class OrganizationEditDTO.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class OrganizationEditDTO
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $fo_api_code;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $payment_type;
}
