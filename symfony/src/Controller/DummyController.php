<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DummyController extends AbstractController
{
    #[Route('/dummy', name: 'app_dummy')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!!!',
            'path' => 'src/Controller/DummyController.php',
        ]);
    }
}
