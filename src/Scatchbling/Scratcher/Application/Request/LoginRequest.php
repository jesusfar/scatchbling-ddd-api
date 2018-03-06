<?php

namespace Scatchbling\Scratcher\Application\Request;


/**
 * Class LoginRequest
 * @package Scatchbling\Scratcher\Application\Request
 */
class LoginRequest
{
    private $user;
    private $password;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}