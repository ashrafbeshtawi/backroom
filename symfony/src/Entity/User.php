<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\OpenApi\Model;
use App\Controller\ActivateUserController;
use App\Processor\User\POSTUserProcessor;
use App\Processor\User\PUTUserProcessor;
use App\Repository\UserRepository;
use App\State\ActivateUserProvider;
use App\State\CurrentUserProvider;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
  operations: [
    new GetCollection(security: "is_granted('ROLE_ADMIN')"),
    new GetCollection(
      uriTemplate: '/users/whoami/',
      security: "is_granted('ROLE_USER')",
      provider: CurrentUserProvider::class,
    ),
    new Get(security: "is_granted('ROLE_ADMIN') or (is_granted('ROLE_USER') and object.getId() == user.getId())"),
    new Get(
      uriTemplate: '/activate/{id}/{secret}',
      requirements: [
        'id' => '\d+',
        'secret' => '\d+'
      ],
      controller: ActivateUserController::class,
      openapi: new Model\Operation(
        responses: [
          '200' => [
            'description'=> 'Successful activation',
          ],
          '400' => [
            'description'=> 'Activation failed',
          ],
        ],
        summary: 'Activate User with Id and Secret',
      ),
      provider: ActivateUserProvider::class,
    ),
    new Post(
      processor: POSTUserProcessor::class
    ),
    new Put(
      security: "is_granted('ROLE_ADMIN') or (is_granted('ROLE_USER') and object.getId() == user.getId())",
      processor: PUTUserProcessor::class
    ),
  ],
  normalizationContext: ['groups' => ['read']],
  denormalizationContext: ['groups' => ['write']]
)]
#[Entity(repositoryClass: UserRepository::class)]
#[Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface {
    #[Id]
    #[GeneratedValue]
    #[Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[Column(length: 180, unique: true)]
    #[Assert\Email()]
    #[Groups(['read', 'write'])]
    private ?string $email = null;

    #[Column]
    #[Groups(['read'])]
    private array $roles = [];

    #[Column]
    #[Assert\Length(min: 8)]
    #[Groups(['write'])]
    private ?string $password = null;

    #[OneToOne(inversedBy: 'user', targetEntity: Profile::class, cascade: ["persist"])]
    private Profile $profile;

  #[Groups(['read'])]
  public function getProfileId(): ?int {
      return $this->profile->getId();
    }

    public function getId(): ?int {
        return $this->id;
    }

  /**
   * @param int|null $id
   */
  public function setId(?int $id): void {
    $this->id = $id;
  }


    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self {
        $this->roles = $roles;

        return $this;
    }

  /**
   * @param string $role
   * @return bool
   */
  public function hasRole(string $role): bool {
    return in_array($role, $this->roles);
  }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

  /**
   * @return Profile
   */
  public function getProfile(): Profile {
    return $this->profile;
  }

  /**
   * @param Profile $profile
   * @return User
   */
  public function setProfile(Profile $profile): self {
    $this->profile = $profile;
    return $this;
  }


    /**
     * @see UserInterface
     */
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
