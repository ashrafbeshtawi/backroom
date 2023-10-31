<?php

namespace App\Processor\Picture;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;


final class DELETEPictureProcessor implements ProcessorInterface
{
  public function __construct(
    private readonly EntityManagerInterface $entityManager,
  ) {
  }

  /**
   */
  public function process($data, Operation $operation, array $uriVariables = [], array $context = []) {
    /** @var Picture $data */
    $path = $data->getFilePath();
    $fs = new Filesystem();
    if ($fs->exists(Picture::UPLOAD_DESTINATION . $path)) {
      $fs->remove(Picture::UPLOAD_DESTINATION . $path);
    }
    $this->entityManager->remove($data);
    $this->entityManager->flush();
  }
}
