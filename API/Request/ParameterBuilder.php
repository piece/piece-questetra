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

namespace Piece\Questetra\API\Request;

/**
 * @package    Piece_Questetra
 * @copyright  2012 KUBO Atsuhiro <kubo@iteman.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class ParameterBuilder
{
    const DATA_TYPE_STRING = 'String';
    const DATA_TYPE_NUMERIC = 'Numeric';
    const DATA_TYPE_DATETIME = 'Date Time';

    /**
     * @var array
     */
    private static $PARAMETER_NAME_SUFFIXES = array(
        self::DATA_TYPE_STRING => 'input',
        self::DATA_TYPE_NUMERIC => 'input',
        self::DATA_TYPE_DATETIME => 'datetime',
    );

    /**
     * @param string
     */
    protected $title;

    /**
     * @param integer
     */
    protected $processInstanceId;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @param string $title
     * @return \Piece\Questetra\API\Request\ParameterBuilder
     */
    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param integer $processInstanceId
     * @return \Piece\Questetra\API\Request\ParameterBuilder
     */
    public function processInstanceId($processInstanceId)
    {
        $this->processInstanceId = $processInstanceId;
        return $this;
    }

    /**
     * @param integer $processDataID
     * @param string $dataType
     * @return \Piece\Questetra\API\Request\ParameterBuilder
     * @throws \UnexpectedValueException
     */
    public function data($processDataID, $dataType, $value)
    {
        $class = basename(__CLASS__);
        if (!array_key_exists($dataType, self::$PARAMETER_NAME_SUFFIXES)) {
            throw new \UnexpectedValueException(sprintf('The data type [ %s ] is not supported. The supported data types (constants): %s',
               $dataType,
               implode(', ', array_map(function ($dataType) use ($class) {
                   return sprintf('%s::%s:', $class, $dataType);
               }, array_keys(self::$PARAMETER_NAME_SUFFIXES)))
            ));
        }

        $this->data[ sprintf('data[%d].%s', $processDataID, self::$PARAMETER_NAME_SUFFIXES[$dataType]) ] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $parameters = $this->data;

        if (!is_null($this->title) && strlen($this->title) > 0) {
            $parameters['title'] = $this->title;
        }

        if (!is_null($this->processInstanceId)) {
            $parameters['processInstanceId'] = $this->processInstanceId;
        }

        return $parameters;
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
