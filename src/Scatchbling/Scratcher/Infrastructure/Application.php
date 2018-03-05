<?php

namespace Scatchbling\Scratcher\Infrastructure;

use Scatchbling\Scratcher\Application\Service\ItemService;
use Scatchbling\Scratcher\Infrastructure\Http\Request;
use Scatchbling\Scratcher\Infrastructure\Http\SimpleRouter;
use Scatchbling\Scratcher\Infrastructure\Persistence\pdo\PDOItemRepository;

/**
 * Class Application
 * @package Scatchbling\Scratcher\Infrastructure
 */
class Application extends SimpleRouter
{
    private $container;

    /**
     * Application constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param mixed $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     *
     */
    public function bootstrap()
    {
        $this->initContainer();
    }

    /**
     * @throws Http\HttpException
     */
    public function run()
    {
        $request = Request::fromEnvironment();

        $this->handle($request);
    }

    /**
     *
     */
    private function initContainer()
    {
        // Repository
        $itemRepository = new PDOItemRepository();
        $this->container['itemRepository'] = $itemRepository;

        // Service Instance
        $this->container['itemService'] = new ItemService($itemRepository);
    }


}