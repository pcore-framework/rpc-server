<?php

declare(strict_types=1);

namespace PCore\RpcServer\Attributes;

use Attribute;

/**
 * Class RpcService
 * @package PCore\RpcServer\Attributes
 * @github https://github.com/pcore-framework/rpc-server
 */
#[Attribute(Attribute::TARGET_CLASS)]
class RpcService
{

    public function __construct(
        public string $name,
        public array  $middlewares = []
    )
    {
    }

}
