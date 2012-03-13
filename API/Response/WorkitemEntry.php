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
class WorkitemEntry
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $allocateDatetime;

    /**
     * @var integer
     */
    protected $allocatedQuserId;

    /**
     * @var string
     */
    protected $allocatedQuserName;

    /**
     * @var integer
     */
    protected $allocatedQgroupId;

    /**
     * @var string
     */
    protected $allocatedQgroupName;

    /**
     * @var \DateTime
     */
    protected $endDatetime;

    /**
     * @var string
     */
    protected $nodeName;

    /**
     * @var integer
     */
    protected $nodeNumber;

    /**
     * @var \DateTime
     */
    protected $offerDatetime;

    /**
     * @var \DateTime
     */
    protected $processInstanceEndDatetime;

    /**
     * @var integer
     */
    protected $processInstanceId;

    /**
     * @var string
     */
    protected $processInstanceIdForView;

    /**
     * @var integer
     */
    protected $processInstanceInitQgroupId;

    /**
     * @var string
     */
    protected $processInstanceInitQgroupName;

    /**
     * @var integer
     */
    protected $processInstanceInitQuserId;

    /**
     * @var string
     */
    protected $processInstanceInitQuserName;

    /**
     * @var \DateTime
     */
    protected $processInstanceStartDatetime;

    /**
     * @var string
     */
    protected $processInstanceState;

    /**
     * @var string
     */
    protected $processInstanceTitle;

    /**
     * @var integer
     */
    protected $processInstanceSequenceNumber;

    /**
     * @var integer
     */
    protected $processModelInfoId;

    /**
     * @var string
     */
    protected $processModelInfoName;

    /**
     * @var integer
     */
    protected $processModelVersion;

    /**
     * @var string
     */
    protected $processModelInfoCategory;

    /**
     * @var \DateTime
     */
    protected $startDatetime;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $swimlaneType;

    /**
     * @var string
     */
    protected $timeLimitDatetime;

    /**
     * @var string
     */
    protected $failType;

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
     * @param \DateTime|string $allocateDatetime
     */
    public function setAllocateDatetime($allocateDatetime)
    {
        if ($allocateDatetime instanceof \DateTime) {
            $this->allocateDatetime = $allocateDatetime;
        } else {
            $this->allocateDatetime = new \DateTime($allocateDatetime);
        }
    }

    /**
     * @return \DateTime
     */
    public function getAllocateDatetime()
    {
        return $this->allocateDatetime;
    }

    /**
     * @param integer $allocatedQuserId
     */
    public function setAllocatedQuserId($allocatedQuserId)
    {
        $this->allocatedQuserId = $allocatedQuserId;
    }

    /**
     * @return integer
     */
    public function getAllocatedQuserId()
    {
        return $this->allocatedQuserId;
    }

    /**
     * @param string $allocatedQuserName
     */
    public function setAllocatedQuserName($allocatedQuserName)
    {
        $this->allocatedQuserName = $allocatedQuserName;
    }

    /**
     * @return string
     */
    public function getAllocatedQuserName()
    {
        return $this->allocatedQuserName;
    }

    /**
     * @param integer $allocatedQgroupId
     */
    public function setAllocatedQgroupId($allocatedQgroupId)
    {
        $this->allocatedQgroupId = $allocatedQgroupId;
    }

    /**
     * @return integer
     */
    public function getAllocatedQgroupId()
    {
        return $this->allocatedQgroupId;
    }

    /**
     * @param string $allocatedQgroupName
     */
    public function setAllocatedQgroupName($allocatedQgroupName)
    {
        $this->allocatedQgroupName = $allocatedQgroupName;
    }

    /**
     * @return string
     */
    public function getAllocatedQgroupName()
    {
        return $this->allocatedQgroupName;
    }

    /**
     * @param \DateTime|string $endDatetime
     */
    public function setEndDatetime($endDatetime)
    {
        if ($endDatetime instanceof \DateTime) {
            $this->endDatetime = $endDatetime;
        } else {
            $this->endDatetime = new \DateTime($endDatetime);
        }
    }

    /**
     * @return \DateTime
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
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
     * @param integer $nodeNumber
     */
    public function setNodeNumber($nodeNumber)
    {
        $this->nodeNumber = $nodeNumber;
    }

    /**
     * @return integer
     */
    public function getNodeNumber()
    {
        return $this->nodeNumber;
    }

    /**
     * @param \DateTime|string $offerDatetime
     */
    public function setOfferDatetime($offerDatetime)
    {
        if ($offerDatetime instanceof \DateTime) {
            $this->offerDatetime = $offerDatetime;
        } else {
            $this->offerDatetime = new \DateTime($offerDatetime);
        }
    }

    /**
     * @return \DateTime
     */
    public function getOfferDatetime()
    {
        return $this->offerDatetime;
    }

    /**
     * @param \DateTime|string $processInstanceEndDatetime
     */
    public function setProcessInstanceEndDatetime($processInstanceEndDatetime)
    {
        if ($processInstanceEndDatetime instanceof \DateTime) {
            $this->processInstanceEndDatetime = $processInstanceEndDatetime;
        } else {
            $this->processInstanceEndDatetime = new \DateTime($processInstanceEndDatetime);
        }
    }

    /**
     * @return \DateTime
     */
    public function getProcessInstanceEndDatetime()
    {
        return $this->processInstanceEndDatetime;
    }

    /**
     * @param integer $processInstanceId
     */
    public function setProcessInstanceId($processInstanceId)
    {
        $this->processInstanceId = $processInstanceId;
    }

    /**
     * @return integer
     */
    public function getProcessInstanceId()
    {
        return $this->processInstanceId;
    }

    /**
     * @param string $processInstanceIdForView
     */
    public function setProcessInstanceIdForView($processInstanceIdForView)
    {
        $this->processInstanceIdForView = $processInstanceIdForView;
    }

    /**
     * @return string
     */
    public function getProcessInstanceIdForView()
    {
        return $this->processInstanceIdForView;
    }

    /**
     * @param integer $processInstanceInitQgroupId
     */
    public function setProcessInstanceInitQgroupId($processInstanceInitQgroupId)
    {
        $this->processInstanceInitQgroupId = $processInstanceInitQgroupId;
    }

    /**
     * @return integer
     */
    public function getProcessInstanceInitQgroupId()
    {
        return $this->processInstanceInitQgroupId;
    }

    /**
     * @param string $processInstanceInitQgroupName
     */
    public function setProcessInstanceInitQgroupName($processInstanceInitQgroupName)
    {
        $this->processInstanceInitQgroupName = $processInstanceInitQgroupName;
    }

    /**
     * @return string
     */
    public function getProcessInstanceInitQgroupName()
    {
        return $this->processInstanceInitQgroupName;
    }

    /**
     * @param integer $processInstanceInitQuserId
     */
    public function setProcessInstanceInitQuserId($processInstanceInitQuserId)
    {
        $this->processInstanceInitQuserId = $processInstanceInitQuserId;
    }

    /**
     * @return integer
     */
    public function getProcessInstanceInitQuserId()
    {
        return $this->processInstanceInitQuserId;
    }

    /**
     * @param string $processInstanceInitQuserName
     */
    public function setProcessInstanceInitQuserName($processInstanceInitQuserName)
    {
        $this->processInstanceInitQuserName = $processInstanceInitQuserName;
    }

    /**
     * @return string
     */
    public function getProcessInstanceInitQuserName()
    {
        return $this->processInstanceInitQuserName;
    }

    /**
     * @param \DateTime|string $processInstanceStartDatetime
     */
    public function setProcessInstanceStartDatetime($processInstanceStartDatetime)
    {
        if ($processInstanceStartDatetime instanceof \DateTime) {
            $this->processInstanceStartDatetime = $processInstanceStartDatetime;
        } else {
            $this->processInstanceStartDatetime = new \DateTime($processInstanceStartDatetime);
        }
    }

    /**
     * @return \DateTime
     */
    public function getProcessInstanceStartDatetime()
    {
        return $this->processInstanceStartDatetime;
    }

    /**
     * @param string $processInstanceState
     */
    public function setProcessInstanceState($processInstanceState)
    {
        $this->processInstanceState = $processInstanceState;
    }

    /**
     * @return string
     */
    public function getProcessInstanceState()
    {
        return $this->processInstanceState;
    }

    /**
     * @param string $processInstanceTitle
     */
    public function setProcessInstanceTitle($processInstanceTitle)
    {
        $this->processInstanceTitle = $processInstanceTitle;
    }

    /**
     * @return string
     */
    public function getProcessInstanceTitle()
    {
        return $this->processInstanceTitle;
    }

    /**
     * @param integer $processInstanceSequenceNumber
     */
    public function setProcessInstanceSequenceNumber($processInstanceSequenceNumber)
    {
        $this->processInstanceSequenceNumber = $processInstanceSequenceNumber;
    }

    /**
     * @return integer
     */
    public function getProcessInstanceSequenceNumber()
    {
        return $this->processInstanceSequenceNumber;
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
     * @param \DateTime|string $startDatetime
     */
    public function setStartDatetime($startDatetime)
    {
        if ($startDatetime instanceof \DateTime) {
            $this->startDatetime = $startDatetime;
        } else {
            $this->startDatetime = new \DateTime($startDatetime);
        }
    }

    /**
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $swimlaneType
     */
    public function setSwimlaneType($swimlaneType)
    {
        $this->swimlaneType = $swimlaneType;
    }

    /**
     * @return string
     */
    public function getSwimlaneType()
    {
        return $this->swimlaneType;
    }

    /**
     * @param \DateTime|string $timeLimitDatetime
     */
    public function setTimeLimitDatetime($timeLimitDatetime)
    {
        if ($timeLimitDatetime instanceof \DateTime) {
            $this->timeLimitDatetime = $timeLimitDatetime;
        } else {
            $this->timeLimitDatetime = new \DateTime($timeLimitDatetime);
        }
    }

    /**
     * @return \DateTime
     */
    public function getTimeLimitDatetime()
    {
        return $this->timeLimitDatetime;
    }

    /**
     * @param string $failType
     */
    public function setFailType($failType)
    {
        $this->failType = $failType;
    }

    /**
     * @return string
     */
    public function getFailType()
    {
        return $this->failType;
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
