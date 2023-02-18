<?php

declare(strict_types=1);

namespace PCore\RpcServer;

use PCore\HttpMessage\Bags\{HeaderBag, ParameterBag};
use PCore\HttpMessage\Stream\StandardStream;
use PCore\RpcServer\Bags\ServerBag;
use PCore\RpcServer\Contracts\RpcServerRequestInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class RpcServerRequest
 * @package PCore\RpcServer
 * @github https://github.com/pcore-framework/json-server
 */
class RpcServerRequest implements RpcServerRequestInterface
{

    /**
     * @var ServerBag
     */
    protected ServerBag $serverParams;

    /**
     * @var ParameterBag
     */
    protected ParameterBag $attributes;

    /**
     * @var HeaderBag
     */
    protected HeaderBag $headers;

    /**
     * @var StreamInterface|null
     */
    protected ?StreamInterface $body = null;

    public function __construct(array $headers = [])
    {
        $this->serverParams = new ServerBag();
        $this->attributes = new ParameterBag();
        $this->headers = new HeaderBag($headers);
    }

    /**
     * @param $request
     * @param array $attributes
     * @return static
     */
    public static function createRequest($request, array $attributes = []): RpcServerRequestInterface
    {
        $server = $request->server;
        $header = $request->header;
        $psrRequest = new static($header);
        $psrRequest->serverParams = new ServerBag($server);
        $psrRequest->attributes = new ParameterBag($attributes);
        $psrRequest->body = StandardStream::create((string)$request->getContent());
        return $psrRequest;
    }

    /**
     * @return array
     */
    public function getServerParams(): array
    {
        return $this->serverParams->all();
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers->all();
    }

    /**
     * @param $name
     * @return bool|null
     */
    public function hasHeader($name): ?bool
    {
        return $this->headers->has($name);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getHeader($name): mixed
    {
        return $this->headers->get($name);
    }

    /**
     * @param $name
     * @return string
     */
    public function getHeaderLine($name): string
    {
        if ($this->hasHeader($name)) {
            return implode(', ', $this->getHeader($name));
        }
        return '';
    }

    /**
     * @return StreamInterface|null
     */
    public function getBody(): ?StreamInterface
    {
        return $this->body;
    }

}
