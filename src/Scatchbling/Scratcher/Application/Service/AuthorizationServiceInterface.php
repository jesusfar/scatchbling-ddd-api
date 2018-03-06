<?php

namespace Scatchbling\Scratcher\Application\Service;


use Scatchbling\Scratcher\Application\Request\LoginRequest;

/**
 * Interface AuthorizationServiceInterface
 * @package Scatchbling\Scratcher\Application\Service
 */
interface AuthorizationServiceInterface
{
    /**
     * @param string $token
     * @return mixed
     */
    public function authorization(string $token = null);

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request);
}