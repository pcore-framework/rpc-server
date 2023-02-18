<?php

declare(strict_types=1);

namespace PCore\RpcServer\Events;

use PCore\RpcServer\Contracts\RpcServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class OnRequest
 * @package PCore\RpcServer\Events
 * @github https://github.com/pcore-framework/rpc-server
 */
class OnRequest
{

    /**
     * @var float
     */
    public float $requestedAt;

    public function __construct(
        public RpcServerRequestInterface $request,
        public ?ResponseInterface        $response = null
    )
    {
        $this->requestedAt = microtime(true);
    }

}
