<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * PHP version 5.3
 *
 * Copyright (c) 2012 KUBO Atsuhiro <kubo@iteman.jp>,
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    Piece_Questetra
 * @copyright  2012 KUBO Atsuhiro <kubo@iteman.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version    Release: @package_version@
 * @since      File available since Release 0.1.0
 */

namespace Piece\Questetra\Core;

use Guzzle\Common\Event;
use Guzzle\Http\Client;
use Guzzle\Http\Message\Request;

/**
 * @package    Piece_Questetra
 * @copyright  2012 KUBO Atsuhiro <kubo@iteman.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class QuestetraClient
{
    /**
     * @var \Guzzle\Http\Client
     */
    protected $httpClient;

    /**
     * @param \Piece\Questetra\Core\RequestContext $requestContext
     */
    protected $requestContext;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->httpClient->getEventDispatcher()->addListener('request.error', array($this, 'onRequestError'));
    }

    /**
     * @param \Piece\Questetra\Core\RequestContext $requestContext
     */
    public function setRequestContext(RequestContext $requestContext)
    {
        $this->requestContext = $requestContext;
        $this->httpClient->setBaseUrl($this->requestContext->getContextRoot());
    }

    /**
     * @return \Piece\Questetra\Core\RequestContext
     */
    public function getRequestContext()
    {
        return $this->requestContext;
    }

    /**
     * @param \Guzzle\Common\Event $event
     * @throws \Piece\Questetra\Core\ServiceException
     * @throws \Piece\Questetra\Core\UnauthorizedException
     */
    public function onRequestError(Event $event)
    {
        switch ($event['response']->getStatusCode()) {
        case 200:
            break;
        case 401:
            throw $this->createException('Piece\Questetra\Core\AuthenticationException', $event);
        case 403:
            throw $this->createException('Piece\Questetra\Core\AuthorizationException', $event);
        default:
            throw $this->createException('Piece\Questetra\Core\ServiceException', $event);
        }
    }

    /**
     * @param string $uri
     * @param array $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function get($uri, array $parameters = array())
    {
        $request = $this->httpClient->get($uri); /* @var $request \Guzzle\Http\Message\Request */
        $this->configureRequest($request);
        foreach ($parameters as $name => $value) {
            $request->getQuery()->set($name, $value);
        }
        return $request->send();
    }

    /**
     * @param string $uri
     * @param array $parameters
     * @return \Guzzle\Http\Message\Response
     */
    public function post($uri, array $parameters = array())
    {
        $request = $this->httpClient->post($uri, null, $parameters); /* @var $request \Guzzle\Http\Message\Request */
        $this->configureRequest($request);
        return $request->send();
    }

    /**
     * @param Guzzle\Http\Message\Request $request
     */
    protected function configureRequest(Request $request)
    {
        $request->setAuth(
            $this->requestContext->getUserID(),
            $this->requestContext->getPassword(),
            CURLAUTH_BASIC
        );
    }

    /**
     * @param string $exceptionClass
     * @param \Guzzle\Common\Event $event
     * @return \Piece\Questetra\Core\ServiceException
     */
    protected function createException($exceptionClass, Event $event)
    {
        $serviceException = new $exceptionClass(sprintf('An unexpected HTTP status [ %d %s ] for [ %s ] is returned from Questetra BPM Suite APIs. Context Root: %s, User ID: %s',
            $event['response']->getStatusCode(),
            $event['response']->getReasonPhrase(),
            $event['request']->getUrl(),
            $this->requestContext->getContextRoot(),
            $this->requestContext->getUserID()
        ));
        $serviceException->setRequestContext($this->requestContext);
        $serviceException->setRequest($event['request']);
        $serviceException->setResponse($event['response']);
        return $serviceException;
    }
}

/*
 * Local Variables:
 * mode: php
 * coding: iso-8859-1
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * indent-tabs-mode: nil
 * End:
 */
