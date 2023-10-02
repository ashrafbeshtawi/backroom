<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Entity\PictureType;
use App\Entity\Profile;
use App\Utils\Roles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[AsController]
final class CreateProfilePictureAction extends AbstractController {

  public function __construct(
    private readonly TokenStorageInterface $tokenStorage,
    private readonly EntityManagerInterface $entityManager,
  ) {

  }
  public function __invoke(Request $request): Picture {
    $user = $this->tokenStorage->getToken()?->getUser();
    if (!$user) {
      throw new UnauthorizedHttpException('You must login first');
    }
    $roles = $user->getRoles();
    $uploadedFile = $request->files->get('file');
    $profile = $this->entityManager->getRepository(Profile::class)->findOneBy(['user' => $user]);
    $requestedPictureType = $request->request->get('pictureType');
    /** @var PictureType $registeredPictureType */
    $registeredPictureType = $this->entityManager->getRepository(PictureType::class)->findOneBy(['name' => $requestedPictureType]);
    if (
      !$uploadedFile
      || !$requestedPictureType
      || !$registeredPictureType
      || $registeredPictureType->getName() !== $requestedPictureType
      || !$roles
      || !in_array(Roles::ACTIVATED, $roles, true)
      || !$profile
    ) {
      throw new BadRequestHttpException('file and Picture-Type are required and account must be activated');
    }
    // If max allowed number of this picture type is already uploaded,
    // then return error
    /** @var Picture $picture */
    $pictures = $this->entityManager->getRepository(Picture::class)->findBy([
      'pictureType' => $registeredPictureType,
      'profile' => $profile
    ]);
    if (
      !$registeredPictureType->isLimitedNumber()
      || (
        $registeredPictureType->getMaxNumber() > 0
        && count($pictures) < $registeredPictureType->getMaxNumber()
      )
    ) {
      $picture = new Picture();
      $picture->file = $uploadedFile;
      $picture->setPictureType($registeredPictureType);
      $picture->setProfile($profile);
      return $picture;
    }
    throw new BadRequestHttpException('Max Number of Images already reached');
    foreach ($pictures as $picture) {
      $fs = new Filesystem();
      if ($fs->exists(Picture::UPLOAD_DESTINATION . $picture->getFilePath())) {
        $fs->remove(Picture::UPLOAD_DESTINATION . $picture->getFilePath());
      }
      $this->entityManager->remove($picture);
    }
    $this->entityManager->flush();
  }

  #[Route(path: 'image/{img}', name: 'image', methods: ['GET'])]
  public function image(string $img) : Response {
    $filepath = '../media/uploaded/' . $img;

    $response = new Response(file_get_contents($filepath));

    $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $img);

    $response->headers->set('Content-Disposition', $disposition);
    $response->headers->set('Content-Type', 'image/png');

    return $response;
  }
}
