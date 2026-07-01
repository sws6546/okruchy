<?php

namespace App\Service;

use App\Entity\Logins;
use App\Entity\Writer;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Security
{
    public function __construct(
        private string $jwtKey,
        private EntityManagerInterface $em
    ) {}

    public function login(string $email, string $password, Request $req): JsonResponse
    {
        $user = $this->em->getRepository(Writer::class)->findOneBy(["email" => $email]);

        if (!$this->isUserExist($user)) {
            return new JsonResponse(["error" => "User not found"], Response::HTTP_NOT_FOUND);
        }
        if (!$this->isPasswordOk($user, $password)) {
            return new JsonResponse(["error" => "Bad password"], Response::HTTP_UNAUTHORIZED);
        }

        $this->createLoginLog($user, $req);
        $jwt = $this->generateJWT($user);
        return new JsonResponse(["success" => true, "token" => $jwt], Response::HTTP_ACCEPTED);
    }

    private function createLoginLog(Writer $user, Request $req) {
        $login = new Logins();
        $login->setWriter($user);
        $login->setIp($req->getClientIp());
        $login->setCreatedDate(new \DateTime());

        $this->em->persist($login);
        $this->em->flush();
    }


    public function authorize(Request $request): ?Writer
    {
        $authHeader = $request->headers->get('Authorization');

        if ($authHeader === null || !str_starts_with($authHeader, 'Bearer ')) {
            return null;
        }

        $token = substr($authHeader, strlen('Bearer '));

        $payload = $this->verifyToken($token);

        if ($payload == null) {
            return null;
        }

        $user = $this->em->getRepository(Writer::class)->find($payload->sub);

        if ($user == null) {
            return null;
        }

        return $user;
    }

    private function verifyToken(string $jwtToken): ?object
    {
        try {
            return JWT::decode($jwtToken, new Key($this->jwtKey, 'HS256'));
        } catch (\Exception) {
            return null;
        }
    }

    private function generateJWT(Writer $user): string
    {
        $jwt = JWT::encode(
            payload: [
                'iss' => 'localhost',
                'aud' => 'localhost',
                'iat' => time(),
                'exp' => time() + (3600 * 24 * 3),
                'sub' => $user->getId(),
                'email' => $user->getEmail(),
            ],
            key: $this->jwtKey,
            alg: 'HS256'
        );

        return $jwt;
    }

    private function isPasswordOk(?Writer $user, string $password)
    {
        return password_verify($password, $user->getPassword());
    }

    private function isUserExist(?Writer $user): bool
    {
        return $user != null;
    }
}
