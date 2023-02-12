<?php

declare(strict_types=1);

namespace PCore\RpcServer;

use PCore\RpcServer\Contracts\KernelInterface;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

/**
 * Class Kernel
 * @package PCore\RpcServer
 * @github https://github.com/pcore-framework/rpc-server
 */
class Kernel implements KernelInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

    }

}
