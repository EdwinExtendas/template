<?php

namespace App\DTO\Validation\Api\App;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class NewFuelTransactionDTO.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class NewFuelTransactionDTO
{
    /**
     * @Assert\NotBlank()
     *
     * @var int
     */
    public $point_of_service;

    /**
     * @Assert\NotBlank()
     *
     * @var int
     */
    public $pump_number;

    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    public $product_code;

    /**
     * @Assert\NotBlank()
     *
     * @var int
     */
    public $card;
}
