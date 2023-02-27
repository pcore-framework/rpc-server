<?php

declare(strict_types=1);

namespace PCore\RpcServer;

use BadMethodCallException;
use PCore\RpcMessage\{Error, Request, Response, BaseResponse};
use PCore\RpcMessage\Contracts\ServerRequestInterface;
use PCore\RpcMessage\Stream\StandardStream;
use PCore\RpcServer\Contracts\{MiddlewareInterface,RequestHandlerInterface};
use PCore\Utils\Arr;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
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
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->container->set(ServerRequestInterface::class, $request);
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
            $psrResponse = new BaseResponse();
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
            $psrResponse = new BaseResponse();
            if (!isset($rpcRequest) || ($rpcRequest->hasId())) {
                $rpcResponse = new Response(null, isset($rpcRequest) ? $rpcRequest->getId() : null,
                    new Error($e->getCode(), $e->getMessage())
                );
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
