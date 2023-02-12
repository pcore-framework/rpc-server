<?php

declare(strict_types=1);

namespace PCore\RpcServer;

use PCore\HttpMessage\Cookie;
use PCore\HttpMessage\Stream\FileStream;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseEmitter
 * @package PCore\RpcServer\ResponseEmitter
 * @github https://github.com/pcore-framework/rpc-server
 */
class ResponseEmitter
{

    /**
     * @param ResponseInterface $psrResponse
     * @param $sender
     * @return void
     */
    public function emit(ResponseInterface $psrResponse, $sender = null)
    {
        $sender->status($psrResponse->getStatusCode(), $psrResponse->getReasonPhrase());
        foreach ($psrResponse->getHeader('Set-Cookie') as $cookieLine) {
            $cookie = Cookie::parse($cookieLine);
            $sender->cookie(
                $cookie->getName(),
                $cookie->getValue(),
                $cookie->getExpires(),
                $cookie->getPath(),
                $cookie->getDomain(),
                $cookie->isSecure(),
                $cookie->isHttponly(),
                $cookie->getSameSite()
            );
        }
        $psrResponse = $psrResponse->withoutHeader('Set-Cookie');
        foreach ($psrResponse->getHeaders() as $key => $value) {
            $sender->header($key, implode(', ', $value));
        }
        $body = $psrResponse->getBody();
        switch (true) {
            case $body instanceof FileStream:
                $sender->sendfile($body->getFilename(), $body->getOffset(), $body->getLength());
                break;
            default:
                $sender->end($body?->getContents());
        }
        $body?->close();
    }

}
