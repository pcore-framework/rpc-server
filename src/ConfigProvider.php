<?php

declare(strict_types=1);

namespace PCore\RpcServer;

/**
 * Class ConfigProvider
 * @package PCore\RpcServer
 * @github https://github.com/pcore-framework/rpc-server
 */
class ConfigProvider
{

    public function __invoke()
    {
        return [
            'bindings' => [
                'PCore\RpcServer\Contracts\KernelInterface' => 'PCore\RpcServer\Kernel'
            ]
        ];
    }

}
