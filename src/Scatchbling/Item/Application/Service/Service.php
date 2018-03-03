<?php

namespace Scatchbling\Item\Application\Service;


/**
 * Interface Service
 * @package Scatchbling\Item\Application\Service
 */
interface Service
{
    /**
     * @param $request
     * @return mixed
     */
    public function execute($request);
}