<?php

declare(strict_types=1);

namespace PCore\RpcServer;

use PCore\HttpMessage\Bags\ParameterBag;

/**
 * Class ServerBag
 * @package PCore\RpcServer
 * @github https://github.com/pcore-framework/json-server
 */
class ServerBag extends ParameterBag
{

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        $headers = [];
        if (isset($headers['AUTHORIZATION'])) {
            return $headers;
        }
        return $headers;
    }

}
