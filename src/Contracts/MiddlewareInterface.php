<?php

declare(strict_types=1);

namespace PCore\RpcServer\Contracts;

/**
 * Interface MiddlewareInterface
 * @package PCore\RpcServer\Contracts
 * @github https://github.com/pcore-framework/rpc-server
 */
interface MiddlewareInterface
{

    /**
     * @return mixed
     */
    public function process();

}
