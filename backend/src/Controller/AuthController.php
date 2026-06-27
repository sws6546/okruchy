<?php

namespace App\Controller;

use App\Service\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    #[Route('/auth', name: 'app_auth')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }

    #[Route('/auth/getuser', methods: ["POST"])]
    public function userFromEmail(Request $req, Security $security) {
        $data = $req->toArray();
        if(!isset($data['email']) or !isset($data["password"])) {
            return $this->json(['error' => "There is not email field provided"], Response::HTTP_BAD_REQUEST);
        }

        return $security->login($data["email"], $data["password"]);
    }
}
