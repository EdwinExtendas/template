<?php

namespace App\DTO\Validation\Api\Cms\Organization;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class OrganizationDTO.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class OrganizationCreateDTO extends OrganizationEditDTO
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $user_client_id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $client_id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $client_secret;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $grant_type;
}
