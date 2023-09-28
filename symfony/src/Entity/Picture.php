<?php
// api/src/Entity/MediaObject.php
namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Controller\CreateProfilePictureAction;
use ArrayObject;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity]
#[ApiResource(
  types: ['https://schema.org/MediaObject'],
  operations: [
    new Get(),
    new GetCollection(),
    new Post(
      controller: CreateProfilePictureAction::class,
      openapi: new Model\Operation(
        requestBody: new Model\RequestBody(
          content: new ArrayObject([
            'multipart/form-data' => [
              'schema' => [
                'type' => 'object',
                'properties' => [
                  'file' => [
                    'type' => 'string',
                    'format' => 'binary'
                  ],
                  'title' => [
                    'type' => 'string',
                  ],
                ]
              ]
            ]
          ])
        )
      ),
      validationContext: ['groups' => ['Default', 'media_object_create']],
      deserialize: false,
    )
  ],
  normalizationContext: ['groups' => ['read']]
)]
class Picture {
  public const UPLOAD_DESTINATION = '../media/uploaded/';
  public const ALLOWED_TITELS = [self::PROFILE];
  public const PROFILE = 'profile';
  #[ORM\Id, ORM\Column, ORM\GeneratedValue]
  private ?int $id = null;

  #[ApiProperty(types: ['https://schema.org/contentUrl'])]
  #[Groups(['read'])]
  public ?string $contentUrl = null;

  #[Vich\UploadableField(mapping: "media_object", fileNameProperty: "filePath")]
  #[Assert\NotNull(groups: ['media_object_create'])]
  public ?File $file = null;

  #[ORM\Column(nullable: true)]
  public ?string $filePath = null;

  #[ORM\ManyToOne(inversedBy: 'picture')]
  #[ORM\JoinColumn(nullable: false)]
  private ?Profile $profile = null;

  #[ORM\Column(nullable: true)]
  #[Assert\NotNull]
  #[Assert\NotBlank]
  #[Groups(['read'])]
  public ?string $title = null;

  public function getId(): ?int {
    return $this->id;
  }

  #[Groups(['read'])]
  public function getProfileId(): ?int {
    return $this->profile->getId();
  }
  public function getProfile(): ?Profile {
    return $this->profile;
  }

  public function setProfile(?Profile $profile): self {
    $this->profile = $profile;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getTitle(): ?string {
    return $this->title;
  }

  /**
   * @param string|null $title
   */
  public function setTitle(?string $title): void {
    $this->title = $title;
  }

  /**
   * @return string|null
   */
  public function getFilePath(): ?string
  {
    return $this->filePath;
  }

  /**
   * @param string|null $filePath
   */
  public function setFilePath(?string $filePath): void
  {
    $this->filePath = $filePath;
  }



}
