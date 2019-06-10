<?php

namespace App\DTO\Validation\Api\App;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserInput.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
final class UserRegisterDTO
{
    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    public $api_code;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @var string
     */
    public $email;

    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    public $phone_number;

    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    public $pan;

    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    public $card_number;
}
