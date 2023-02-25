<?php

declare(strict_types=1);

namespace PCore\RpcServer;

use InvalidArgumentException;
use PCore\Di\Reflection;
use PCore\RpcServer\Contracts\{KernelInterface, RpcServerRequestInterface};
use Psr\Container\{ContainerExceptionInterface, ContainerInterface, NotFoundExceptionInterface};
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use ReflectionMethod;

/**
 * Class Kernel
 * @package PCore\RpcServer
 * @github https://github.com/pcore-framework/rpc-server
 */
class Kernel implements KernelInterface
{

    /**
     * @var array
     */
    protected array $services = [];

    final public function __construct(protected ContainerInterface $container)
    {
    }

    /**
     * @param RpcServerRequestInterface $request
     * @return ResponseInterface
     * @throws ReflectionException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(RpcServerRequestInterface $request): ResponseInterface
    {
        return (new RequestHandler($this->container, $this->services))->handle($request);
    }

    /**
     * @param string $name
     * @param string $class
     * @param $middlewares
     * @return void
     * @throws ReflectionException
     */
    public function register(string $name, string $class, $middlewares): void
    {
        if (isset($this->services[$name])) {
            throw new InvalidArgumentException('Сервис \'' . $name . '\' был зарегистрирован');
        }
        foreach (Reflection::methods($class, ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            $reflectionMethodName = $reflectionMethod->getName();
            $this->services[$name][$reflectionMethodName] = [
                'service' => [$class, $reflectionMethodName],
                'middleware' => $middlewares
            ];
        }
    }

}
