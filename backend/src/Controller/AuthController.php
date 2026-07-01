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

        return $security->login($data["email"], $data["password"], $request);
        // TODO: recaptcha
        // TODO: check if ip in Loggins is ok
    }

    #[Route('/auth/check_login', methods: ["GET"])]
    public function checkLogin(Request $request, Security $security): JsonResponse {
        $user = $security->authorize($request);
        // dump($user);
        if ($user == null) {
            return $this->json(["err" => "Bad token"], Response::HTTP_UNAUTHORIZED);
        }
        return $this->json([
            "id" => $user->getId(),
            "username" => $user->getUsername(),
            "email" => $user->getEmail()
        ]);
    }
}
