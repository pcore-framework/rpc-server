<?php

declare(strict_types=1);

namespace PCore\RpcServer\Contracts;

use Psr\Http\Message\StreamInterface;

/**
 * Interface RpcServerRequestInterface
 * @package PCore\RpcServer\Contracts
 * @github https://github.com/pcore-framework/rpc-server
 */
interface RpcServerRequestInterface
{

    /**
     * @return mixed
     */
    public function getHeaders(): mixed;

    /**
     * @return StreamInterface|null
     */
    public function getBody(): ?StreamInterface;

}
