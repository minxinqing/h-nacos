<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Hyperf\Nacos\Config\Listener;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\MainWorkerStart;
use Hyperf\Nacos\Api\NacosInstance as NacosInstanceApi;
use Hyperf\Nacos\Api\NacosService as NacosServiceApi;
use Hyperf\Nacos\Config\Client;
use Hyperf\Nacos\Exception\RuntimeException;
use Hyperf\Nacos\Service\Instance;
use Hyperf\Nacos\Service\Service;
use Psr\Container\ContainerInterface;

class MainWorkerStartListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    /**
     * @var ConfigInterface
     */
    protected $config;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $container->get(StdoutLoggerInterface::class);
        $this->config = $container->get(ConfigInterface::class);
    }

    public function listen(): array
    {
        return [
            MainWorkerStart::class,
        ];
    }

    public function process(object $event)
    {
        if (! $this->config->get('nacos.config.enable', false)) {
            return;
        }

        $client = $this->container->get(Client::class);
        foreach ($client->pull() as $key => $conf) {
            $this->config->set($key, $conf);
        }
    }
}
