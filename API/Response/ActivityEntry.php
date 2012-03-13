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

namespace Piece\Questetra\API\Response;

/**
 * @package    Piece_Questetra
 * @copyright  2012 KUBO Atsuhiro <kubo@iteman.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class ActivityEntry
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $nodeName;

    /**
     * @var integer
     */
    protected $processModelInfoId;

    /**
     * @var integer
     */
    protected $processModelId;

    /**
     * @var integer
     */
    protected $processModelVersion;

    /**
     * @var string
     */
    protected $processModelInfoName;

    /**
     * @var string
     */
    protected $processModelInfoCategory;

    /**
     * @var integer
     */
    protected $processModelInfoViewPriority;

    /**
     * @var \DateTime
     */
    protected $processModelActivateDatetime;

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $nodeName
     */
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;
    }

    /**
     * @return string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }

    /**
     * @param integer $processModelInfoId
     */
    public function setProcessModelInfoId($processModelInfoId)
    {
        $this->processModelInfoId = $processModelInfoId;
    }

    /**
     * @return integer
     */
    public function getProcessModelInfoId()
    {
        return $this->processModelInfoId;
    }

    /**
     * @param integer $processModelId
     */
    public function setProcessModelId($processModelId)
    {
        $this->processModelId = $processModelId;
    }

    /**
     * @return integer
     */
    public function getProcessModelId()
    {
        return $this->processModelId;
    }

    /**
     * @param integer $processModelVersion
     */
    public function setProcessModelVersion($processModelVersion)
    {
        $this->processModelVersion = $processModelVersion;
    }

    /**
     * @return integer
     */
    public function getProcessModelVersion()
    {
        return $this->processModelVersion;
    }

    /**
     * @param string $processModelInfoName
     */
    public function setProcessModelInfoName($processModelInfoName)
    {
        $this->processModelInfoName = $processModelInfoName;
    }

    /**
     * @return string
     */
    public function getProcessModelInfoName()
    {
        return $this->processModelInfoName;
    }

    /**
     * @param string $processModelInfoCategory
     */
    public function setProcessModelInfoCategory($processModelInfoCategory)
    {
        $this->processModelInfoCategory = $processModelInfoCategory;
    }

    /**
     * @return string
     */
    public function getProcessModelInfoCategory()
    {
        return $this->processModelInfoCategory;
    }

    /**
     * @param integer $processModelInfoViewPriority
     */
    public function setProcessModelInfoViewPriority($processModelInfoViewPriority)
    {
        $this->processModelInfoViewPriority = $processModelInfoViewPriority;
    }

    /**
     * @return integer
     */
    public function getProcessModelInfoViewPriority()
    {
        return $this->processModelInfoViewPriority;
    }

    /**
     * @param \DateTime|string $processModelActivateDatetime
     */
    public function setProcessModelActivateDatetime($processModelActivateDatetime)
    {
        if ($processModelActivateDatetime instanceof \DateTime) {
            $this->processModelActivateDatetime = $processModelActivateDatetime;
        } else {
            $this->processModelActivateDatetime = new \DateTime($processModelActivateDatetime);
        }
    }

    /**
     * @return \DateTime
     */
    public function getProcessModelActivateDatetime()
    {
        return $this->processModelActivateDatetime;
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
