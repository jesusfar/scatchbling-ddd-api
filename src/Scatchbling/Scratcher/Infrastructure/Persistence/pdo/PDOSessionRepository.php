<?php

namespace Scatchbling\Scratcher\Infrastructure\Persistence\pdo;


use Scatchbling\Scratcher\Domain\Model\Session;
use Scatchbling\Scratcher\Domain\Model\SessionId;
use Scatchbling\Scratcher\Domain\Model\SessionRepository;

/**
 * Class PDOSessionRepository
 * @package Scatchbling\Scratcher\Infrastructure\Persistence\pdo
 */
class PDOSessionRepository extends PDORepository implements SessionRepository
{

    /**
     * PDOSessionRepository constructor.
     * @param $connection
     */
    public function __construct(PDOConnection $connection)
    {
        parent::__construct($connection);
    }

    /**
     * @param Session $session
     * @return mixed
     */
    public function save(Session $session)
    {
        $sql = <<<EOQ
INSERT INTO sessions(session_id, created_at, expires_at, token) 
VALUES (:sessionId, :createAt, :expiresAt, :token)
EOQ;
        $args = [
            ':sessionId' => $session->getSessionId()->getId(),
            ':createAt' => $session->getCreateAt(),
            ':expiresAt' => $session->getExpiresAt(),
            ':token' => $session->getToken(),
        ];

        return $this->execute($sql, $args);
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function findOneByToken(string $token)
    {
        $sql = <<<EOQ
SELECT * FROM sessions WHERE token = :token
EOQ;
        $rows = $this->query($sql, [':token' => $token]);

        if (count($rows) == 1) {
            return $this->buildSession($rows[0]);
        }

        return null;
    }

    /**
     * @param array $data
     * @return Session
     */
    private function buildSession(array $data) : Session
    {
        return new Session(
            new SessionId($data['session_id']),
            $data['token'],
            intval($data['created_at']),
            intval($data['expires_at'])
        );
    }
}