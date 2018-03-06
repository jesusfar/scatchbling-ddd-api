<?php

namespace Scatchbling\Scratcher\Domain\Model;


/**
 * Class Session
 * @package Scatchbling\Scratcher\Domain\Model
 */
class Session
{
    /**
     * Default expiration time 30 minutes
     */
    const DEFAULT_EXPIRATION_TIME = 1800;
    /**
     * @var SessionId
     */
    private $sessionId;
    /**
     * @var int
     */
    private $createAt;
    /**
     * @var int
     */
    private $expiresAt;
    /**
     * @var string
     */
    private $token;

    /**
     * Session constructor.
     * @param SessionId $sessionId
     * @param string $token
     * @param int $createdAt
     * @param int $expiresAt
     */
    public function __construct(SessionId $sessionId, string $token, int $createdAt = 0, int $expiresAt = 0)
    {
        $this->sessionId = $sessionId;
        $this->createAt = ($createdAt) ? $createdAt : time();
        $this->expiresAt = ($expiresAt) ? $expiresAt : time() + self::DEFAULT_EXPIRATION_TIME;
        $this->token = $token;
    }

    /**
     * @return SessionId
     */
    public function getSessionId(): SessionId
    {
        return $this->sessionId;
    }

    /**
     * @return int
     */
    public function getCreateAt(): int
    {
        return $this->createAt;
    }

    /**
     * @return int
     */
    public function getExpiresAt(): int
    {
        return $this->expiresAt;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }


    /**
     * @return bool
     */
    public function tokenIsAlive(): bool
    {
        return $this->expiresAt > time();
    }
}