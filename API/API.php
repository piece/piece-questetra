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

namespace Piece\Questetra\API;

use Guzzle\Http\Message\Response;

use Piece\Questetra\API\Response\ErrorEntry;
use Piece\Questetra\Core\QuestetraClient;
use Piece\Questetra\Core\RequestContext;
use Piece\Questetra\Core\ServiceException;

/**
 * @package    Piece_Questetra
 * @copyright  2012 KUBO Atsuhiro <kubo@iteman.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
abstract class API
{
    /**
     * @var \Piece\Questetra\Core\QuestetraClient
     */
    protected $questetraClient;

    /**
     * @param \Piece\Questetra\Core\QuestetraClient $questetraClient
     */
    public function __construct(QuestetraClient $questetraClient)
    {
        $this->questetraClient = $questetraClient;
    }

    /**
     * @param \Piece\Questetra\Core\RequestContext $requestContext
     */
    public function setRequestContext(RequestContext $requestContext)
    {
        $this->questetraClient->setRequestContext($requestContext);
    }

    /**
     * @return \Piece\Questetra\Core\RequestContext
     */
    public function getRequestContext()
    {
        return $this->questetraClient->getRequestContext();
    }

    /**
     * @param array $data
     * @param mixed $object
     * @throws \UnexpectedValueException
     */
    protected function transformToObject(array $data, $object)
    {
        foreach ($data as $attribute => $value) {
            $setter = 'set' . $attribute;
            if (method_exists($object, $setter)) {
                call_user_func(array($object, $setter), $value);
            }
        }
    }

    /**
     * @param \use Piece\Questetra\Core\ServiceException $e
     * @return \Piece\Questetra\API\ErrorResponseException
     * @throws \UnexpectedValueException
     */
    protected function createErrorResponseException(ServiceException $serviceException)
    {
        $data = $this->parseJSON($serviceException->getResponse());
        if (!array_key_exists('errors', $data)) {
            throw new \UnexpectedValueException(sprintf("The key 'errors' is not found in the data that is returned from [ %s ].",
                $serviceException->getRequest()->getUrl()
            ));
        }
        if (!is_array($data['errors'])) {
            throw new \UnexpectedValueException("The value of the key 'errors' is not an array.");
        }

        $errors = array();
        foreach ($data['errors'] as $error) {
            $errorEntry = new ErrorEntry();
            $this->transformToObject($error, $errorEntry);
            $errors[] = $errorEntry;
        }

        $errorResponseException = new ErrorResponseException($serviceException->getMessage());
        $errorResponseException->setRequestContext($serviceException->getRequestContext());
        $errorResponseException->setRequest($serviceException->getRequest());
        $errorResponseException->setResponse($serviceException->getResponse());
        $errorResponseException->setErrors($errors);
        return $errorResponseException;
    }

    /**
     * @param \Guzzle\Http\Message\Response $response
     * @return array
     */
    protected function parseJSONResponse(Response $response)
    {
        return json_decode($response->getBody(true), true);
    }

    /**
     * @param \Guzzle\Http\Message\Response $response
     * @return \SimpleXMLElement
     */
    protected function parseXMLResponse(Response $response)
    {
        return simplexml_load_string($response->getBody(true));
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
