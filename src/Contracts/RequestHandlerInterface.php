<?php

declare(strict_types=1);

namespace PCore\RpcServer\Contracts;

/**
 * Interface RequestHandlerInterface
 * @package PCore\RpcServer\Contracts
 * @github https://github.com/pcore-framework/rpc-server
 */
interface RequestHandlerInterface
{

    /**
     * @param RpcServerRequestInterface $request
     * @return mixed
     */
    public function handle(RpcServerRequestInterface $request);

}
