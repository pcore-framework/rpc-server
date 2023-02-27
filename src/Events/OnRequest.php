<?php

declare(strict_types=1);

namespace PCore\RpcServer\Events;

use PCore\RpcMessage\Contracts\ServerRequestInterface;
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
        public ServerRequestInterface $request,
        public ?ResponseInterface     $response = null
    )
    {
        $this->requestedAt = microtime(true);
    }

}
