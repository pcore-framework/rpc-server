<?php

declare(strict_types=1);

namespace PCore\RpcServer\Contracts;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface KernelInterface
 * @package PCore\RpcServer\Contracts
 * @github https://github.com/pcore-framework/rpc-server
 */
interface KernelInterface
{

    /**
     * @param RpcServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RpcServerRequestInterface $request): ResponseInterface;

}
