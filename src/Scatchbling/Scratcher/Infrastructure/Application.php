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
    private $pathConfig;

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
        $this->loadConfig();
        $this->initContainer();
    }

    /**
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
        $config = $this->container['config'];
        // Repository
        $itemRepository = new PDOItemRepository($config['database']);
        $this->container['itemRepository'] = $itemRepository;

        // Service Instance
        $this->container['itemService'] = new ItemService($itemRepository);
    }

    public function withConfig(string $pathConfig)
    {
        $this->pathConfig = $pathConfig;
        return $this;
    }

    private function loadConfig()
    {
        if ($this->pathConfig != null) {
            $this->container['config'] = json_decode(file_get_contents($this->pathConfig), TRUE);
        }
    }


}