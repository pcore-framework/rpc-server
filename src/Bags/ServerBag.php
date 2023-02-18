<?php

declare(strict_types=1);

namespace PCore\RpcServer\Bags;

use PCore\HttpMessage\Bags\ParameterBag;

/**
 * Class ServerBag
 * @package PCore\RpcServer\Bags
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

    /**
     * @param array $parameters
     * @return void
     */
    public function replace(array $parameters = []): void
    {
        $this->parameters = array_change_key_case($parameters, CASE_UPPER);
    }

}
