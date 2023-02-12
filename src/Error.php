<?php

declare(strict_types=1);

namespace PCore\RpcServer;

use JsonSerializable;
use function get_object_vars;

/**
 * Class Error
 * @package PCore\RpcServer
 * @github https://github.com/pcore-framework/rpc-server
 */
class Error implements JsonSerializable
{

    public function __construct(protected int $code, protected string $message)
    {
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

}
