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
// TODO: Create Delete operation :)
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
                  'pictureType' => [
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

  #[ORM\ManyToOne(inversedBy: 'pictures')]
  #[ORM\JoinColumn(nullable: false)]
  #[Groups(['read', 'write'])]
  private ?PictureType $pictureType = null;

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

  public function getPictureType(): ?PictureType
  {
      return $this->pictureType;
  }

  public function setPictureType(?PictureType $pictureType): self
  {
      $this->pictureType = $pictureType;

      return $this;
  }



}
