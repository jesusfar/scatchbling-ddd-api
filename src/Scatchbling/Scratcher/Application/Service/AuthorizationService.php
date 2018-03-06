<?php

namespace Scatchbling\Scratcher\Application\Service;


use Scatchbling\Scratcher\Application\Request\LoginRequest;
use Scatchbling\Scratcher\Domain\Exception\AuthorizationException;
use Scatchbling\Scratcher\Domain\Model\Session;
use Scatchbling\Scratcher\Domain\Model\SessionId;
use Scatchbling\Scratcher\Domain\Model\SessionRepository;

/**
 * Class AuthorizationService
 * @package Scatchbling\Scratcher\Application\Service
 */
class AuthorizationService implements AuthorizationServiceInterface
{

    /**
     * @var array
     */
    private $credentials = [];

    /**
     * @var SessionRepository
     */
    private $sessionRepository;

    /**
     * AuthorizationService constructor.
     * @param SessionRepository $sessionRepository
     * @param array $credentials
     */
    public function __construct(SessionRepository $sessionRepository, array $credentials)
    {
        $this->sessionRepository = $sessionRepository;
        $this->credentials = $credentials;
    }


    /**
     * @param string $token
     * @return mixed
     * @throws AuthorizationException
     */
    public function authorization(string $token = null)
    {
        if ($token == null) {
            throw new AuthorizationException("Access denied");
        }

        $token = str_replace('Bearer ', '', $token);

        $session = $this->sessionRepository->findOneByToken($token);

        if ($session == null) {
            throw new AuthorizationException("Access denied.");
        }

        if (!$session->tokenIsAlive()) {
            throw new AuthorizationException("Token is expired.");
        }

        return true;
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function login(LoginRequest $request)
    {
        $user = $this->credentials['user'];
        $password = $this->credentials['password'];
        if ($request->getUser() != $user || $request->getPassword() != $password) {
            throw new AuthorizationException("Invalid credentials.");
        }

        $token = $this->generateToken();

        $session = new Session(new SessionId(), $token);

        $this->sessionRepository->save($session);

        return $this->transformToResponse($session);
    }

    /**
     * @return string
     */
    private function generateToken()
    {
        $token = openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);
        return $token;
    }

    /**
     * @param Session $session
     * @return array
     */
    private function transformToResponse(Session $session)
    {
        return [
            'token' => $session->getToken(),
            'created_at' => $session->getCreateAt(),
            'expires_at' => $session->getExpiresAt(),
            'is_alive' => $session->tokenIsAlive(),
        ];
    }


}