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
                  ]
                ]
              ]
            ]
          ])
        )
      ),
      validationContext: ['groups' => ['Default', 'media_object_create']],
      deserialize: false
    )
  ],
  normalizationContext: ['groups' => ['media_object:read']]
)]
class ProfilePicture {
  #[ORM\Id, ORM\Column, ORM\GeneratedValue]
  private ?int $id = null;

  #[ApiProperty(types: ['https://schema.org/contentUrl'])]
  #[Groups(['media_object:read'])]
  public ?string $contentUrl = null;

  #[Vich\UploadableField(mapping: "media_object", fileNameProperty: "filePath")]
  #[Assert\NotNull(groups: ['media_object_create'])]
  public ?File $file = null;

  #[ORM\Column(nullable: true)]
  public ?string $filePath = null;

  public function getId(): ?int {
    return $this->id;
  }
}
