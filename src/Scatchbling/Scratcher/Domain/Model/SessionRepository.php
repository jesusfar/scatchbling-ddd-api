<?php

namespace Scatchbling\Scratcher\Domain\Model;


/**
 * Interface SessionRepository
 * @package Scatchbling\Scratcher\Domain\Model
 */
interface SessionRepository
{
    /**
     * @param Session $session
     * @return mixed
     */
    public function save(Session $session);

    /**
     * @param string $token
     * @return mixed
     */
    public function findOneByToken(string $token);
}