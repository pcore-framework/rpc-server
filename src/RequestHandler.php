<?php

declare(strict_types=1);

namespace PCore\RpcServer;

use BadMethodCallException;
use PCore\HttpMessage\Response as PsrResponse;
use PCore\HttpMessage\Stream\StandardStream;
use PCore\RpcServer\Contracts\{MiddlewareInterface, RpcServerRequestInterface};
use PCore\RpcServer\Contracts\RequestHandlerInterface;
use PCore\Utils\Arr;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;
use Throwable;

/**
 * Class RequestHandler
 * @package PCore\RpcServer
 * @github https://github.com/pcore-framework/rpc-server
 */
class RequestHandler implements RequestHandlerInterface
{

    public function __construct(
        protected ContainerInterface $container,
        protected array              $services = []
    )
    {
    }

    /**
     * @param RpcServerRequestInterface $request
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function handle(RpcServerRequestInterface $request): ResponseInterface
    {
        $this->container->set(RpcServerRequestInterface::class, $request);
        try {
            $rpcRequest = Request::createFromPsrRequest($request);
            if (is_null($service = $this->getService($rpcRequest->getMethod()))) {
                throw new BadMethodCallException('Метод не найден', -32601);
            }
            if ($middlewareClass = array_shift($service['middleware'])) {
                $middleware = $this->container->make($middlewareClass);
                if ($middleware instanceof MiddlewareInterface) {
                    $middleware->process($request, $this);
                }
            }
            $result = call($service['service'], $rpcRequest->getParams());
            $psrResponse = new PsrResponse();
            if ($rpcRequest->hasId()) {
                $psrResponse = $psrResponse
                    ->withHeader('Content-Type', 'application/json; charset=utf-8')
                    ->withBody(StandardStream::create(json_encode([
                        'jsonrpc' => $rpcRequest->getJsonRpc(),
                        'result' => $result,
                        'id' => $rpcRequest->getId()
                    ])));
            }
            return $psrResponse;
        } catch (Throwable $e) {
            $psrResponse = new PsrResponse();
            if (!isset($rpcRequest) || ($rpcRequest->hasId())) {
                $rpcResponse = new Response(null, isset($rpcRequest) ? $rpcRequest->getId() : null,
                    new Error($e->getCode(), $e->getMessage())
                );
                $logger = $this->container->make(LoggerInterface::class);
                $logger->get('rpcError')->debug($e, []);
                $psrResponse = $psrResponse
                    ->withHeader('Content-Type', 'application/json; charset=utf-8')
                    ->withBody(StandardStream::create(json_encode($rpcResponse, JSON_UNESCAPED_UNICODE)));
            }
            return $psrResponse;
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function getService(string $name): mixed
    {
        return Arr::get($this->services, $name);
    }

}
