<?php

declare(strict_types=1);

namespace PCore\RpcServer\Contracts;

use PCore\RpcMessage\Contracts\ServerRequestInterface;

/**
 * Interface RequestHandlerInterface
 * @package PCore\RpcServer\Contracts
 * @github https://github.com/pcore-framework/rpc-server
 */
interface RequestHandlerInterface
{

    /**
     * @param ServerRequestInterface $request
     * @return mixed
     */
    public function handle(ServerRequestInterface $request);

}
