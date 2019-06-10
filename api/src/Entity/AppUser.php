<?php

namespace App\Entity;

use App\DTO\Validation\Api\App\UserRegisterDTO;
use App\DTO\Validation\MobyPayApi\User\UserDTO;
use App\Entity\Traits\DatetimeInfoTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class AppUser.
 *
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="App\Repository\AppUserRepository")
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class AppUser implements UserInterface
{
    public const USER_REGISTERED_SPINPAY = 1;
    public const USER_REGISTERED_MOBYPAY = 2;
    public const USER_INSTRUCTION_MAIL_SEND = 3;
    public const USER_SMS_VERIFICATION_SEND = 4;
    public const USER_VERIFIED = 5;

    public const ROLE_APP = 'ROLE_APP';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_PORTAL = 'ROLE_PORTAL';
    public const ROLE_PHONE = 'ROLE_PHONE';

    use DatetimeInfoTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"public"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organization;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"public"})
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true, unique=true)
     * @Groups({"public"})
     */
    private $phone_number;

    /**
     * @var string
     * @ORM\Column(type="guid", nullable=true, unique=true)
     * @Groups({"public"})
     */
    private $external_id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $client_id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $refresh_token;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $state;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Groups({"public"})
     */
    private $activated = false;

    public function __construct(Organization $organization, $email, $phone_number, $activated = true)
    {
        $this->organization = $organization;
        $this->email = $email;
        $this->phone_number = $phone_number;

        $this->state = self::USER_REGISTERED_SPINPAY;
        $this->roles = [self::ROLE_APP];
        $this->activated = $activated;
    }

    public static function createFromRegisterDTO(UserRegisterDTO $user_register_DTO, Organization $organization)
    {
        return new self(
            $organization,
            $user_register_DTO->email,
            $user_register_DTO->phone_number
        );
    }

    public function updateFromDTO(UserDTO $user_DTO)
    {
        $this->external_id = $user_DTO->id;
        $this->client_id = $user_DTO->client_id;
        $this->password = $user_DTO->password;

        $this->state = self::USER_REGISTERED_MOBYPAY;
    }

    public function isAdmin()
    {
        return in_array(self::ROLE_ADMIN, $this->roles);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_APP
        $roles[] = self::ROLE_APP;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     *
     * @return AppUser
     */
    public function setPhoneNumber(?string $phone_number): AppUser
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string
     */
    public function getExternalId(): ?string
    {
        return $this->external_id;
    }

    /**
     * @param string $external_id
     *
     * @return AppUser
     */
    public function setExternalId(string $external_id): AppUser
    {
        $this->external_id = $external_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientId(): ?string
    {
        return $this->client_id;
    }

    /**
     * @param string $client_id
     *
     * @return AppUser
     */
    public function setClientId(string $client_id): AppUser
    {
        $this->client_id = $client_id;

        return $this;
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * @param int $state
     *
     * @return AppUser
     */
    public function setState(int $state): AppUser
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): ?string
    {
        return $this->refresh_token;
    }

    /**
     * @param string $refresh_token
     *
     * @return AppUser
     */
    public function setRefreshToken(string $refresh_token): AppUser
    {
        $this->refresh_token = $refresh_token;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActivated(): bool
    {
        return $this->activated;
    }

    /**
     * @param bool $activated
     *
     * @return AppUser
     */
    public function setActivated(bool $activated): AppUser
    {
        $this->activated = $activated;

        return $this;
    }

    /**
     * @return \App\Entity\Organization
     */
    public function getOrganization(): Organization
    {
        return $this->organization;
    }

    /**
     * @param mixed $organization
     *
     * @return AppUser
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;

        return $this;
    }
}
