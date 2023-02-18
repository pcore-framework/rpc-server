<?php

declare(strict_types=1);

namespace PCore\RpcServer;

use PCore\HttpMessage\Bags\ParameterBag;

/**
 * Class RpcServerRequest
 * @package PCore\RpcServer
 * @github https://github.com/pcore-framework/json-server
 */
class RpcServerRequest
{

    /**
     * @var ServerBag
     */
    protected ServerBag $serverParams;

    /**
     * @var ParameterBag
     */
    protected ParameterBag $attributes;

    public function __construct()
    {
        $this->serverParams = new ServerBag();
        $this->attributes = new ParameterBag();
    }

    /**
     * @param $request
     * @param array $attributes
     * @return static
     */
    public static function createRequest($request, array $attributes = [])
    {
        $server = $request->server;
        $psrRequest = new static();
        $psrRequest->serverParams = new ServerBag($server);
        $psrRequest->attributes = new ParameterBag($attributes);
        return $psrRequest;
    }

}
