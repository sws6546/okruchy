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
    #[Route('/auth/login', methods: ["POST"])]
    public function login(Request $request, Security $security): JsonResponse
    {
        $data = $request->toArray();
        if (!isset($data["email"]) or !isset($data["password"])) {
            return $this->json(["error" => "There is no email or password fields"], Response::HTTP_BAD_REQUEST);
        }

        return $security->login($data["email"], $data["password"]);
        // TODO: recaptcha
    }
}
