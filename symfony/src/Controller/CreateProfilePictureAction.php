<?php

namespace App\Controller;

use App\Entity\ProfilePicture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class CreateProfilePictureAction extends AbstractController
{
  public function __invoke(Request $request): ProfilePicture
  {
    $uploadedFile = $request->files->get('file');
    if (!$uploadedFile) {
      throw new BadRequestHttpException('"file" is required');
    }

    $profilePicture = new ProfilePicture();
    $profilePicture->file = $uploadedFile;

    return $profilePicture;
  }

  #[Route(path: 'image/{img}', name: 'image', methods: ['GET'])]
  public function image(string $img) : Response {


    $filepath = '../media/profile/' . $img;

    $response = new Response(file_get_contents($filepath));

    $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $img);

    $response->headers->set('Content-Disposition', $disposition);
    $response->headers->set('Content-Type', 'image/png');

    return $response;
  }
}
