<?php

declare(strict_types=1);

namespace PCore\RpcServer;

use PCore\Aop\Collectors\AbstractCollector;
use PCore\JsonRpc\Attributes\RpcService;
use Psr\Container\ContainerExceptionInterface;
use ReflectionException;

/**
 * Class RpcCollector
 * @package PCore\RpcServer
 * @github https://github.com/pcore-framework/json-server
 */
class RpcCollector extends AbstractCollector
{

    /**
     * @param string $class
     * @param object $attribute
     * @return void
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     */
    public static function collectClass(string $class, object $attribute): void
    {
        if ($attribute instanceof RpcService) {
            $service = $attribute->name;
            make(Kernel::class)->register($service, $class);
        }
    }

}
