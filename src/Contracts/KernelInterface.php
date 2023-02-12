<?php

declare(strict_types=1);

namespace PCore\RpcServer\Contracts;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

/**
 * Interface KernelInterface
 * @package PCore\RpcServer
 * @github https://github.com/pcore-framework/rpc-server
 */
interface KernelInterface
{

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface;

}
