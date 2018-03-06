<?php

namespace Scatchbling\Scratcher\Infrastructure\Http;

/**
 * Interface Router
 * @package Scatchbling\Scratcher\Infrastructure\Http
 */
interface Router
{
    /**
     * @param string $pattern
     * @param $callback
     * @return mixed
     */
    public function get(string $pattern, $callback);

    /**
     * @param string $pattern
     * @param $callback
     * @return mixed
     */
    public function post(string $pattern, $callback);

    /**
     * @param string $pattern
     * @param $callback
     * @return mixed
     */
    public function put(string $pattern, $callback);

    /**
     * @param string $pattern
     * @param $callback
     * @return mixed
     */
    public function delete(string $pattern, $callback);

    /**
     * @param $callback
     * @return mixed
     */
    public function before($callback);
}