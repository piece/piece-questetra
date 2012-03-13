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

use Piece\Questetra\API\Response\WorkitemEntry;
use Piece\Questetra\Core\ServiceException;

/**
 * @package    Piece_Questetra
 * @copyright  2012 KUBO Atsuhiro <kubo@iteman.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class Search extends API
{
    const URI_TASK_SEARCH = 'API/OR/Workitem/list';
    const OPTION_END = 'END';
    const OPTION_END_1WEEK = 'END_1WEEK';
    const OPTION_END_THIS_MONTH = 'END_THIS_MONTH';
    const OPTION_END_LAST_MONTH = 'END_LAST_MONTH';
    const OPTION_OPERATING = 'OPERATING';
    const OPTION_TIMELIMIT_PAST = 'TIMELIMIT_PAST';
    const OPTION_TIMELIMIT_1WEEK = 'TIMELIMIT_1WEEK';
    const OPTION_PROCESS_STARTED = 'PROCESS_STARTED';
    const OPTION_PROCESS_FAILED = 'PROCESS_FAILED';
    const OPTION_ALL = 'ALL';
    const SORT_KEY_OFFER_DATETIME = 'offerDatetime';
    const SORT_KEY_END_DATETIME = 'endDatetime';
    const SORT_DIRECTION_ASC = 'ASC';
    const SORT_DIRECTION_DESC = 'DESC';

    /**
     * @param integer $processModelInfoId
     * @param string $option
     * @param integer $limit
     * @param integer $start
     * @param string $sort
     * @param string $dir
     * @throws \Piece\Questetra\API\ErrorResponseException
     * @throws \UnexpectedValueException
     * @return array
     */
    public function searchTasks($processModelInfoId = null, $option = null, $limit = null, $start = null, $sort = null, $dir = null)
    {
        $parameters = array();
        if (!is_null($processModelInfoId)) {
            $parameters['processModelInfoId'] = $processModelInfoId;
        }
        if (!is_null($option)) {
            $parameters['option'] = $option;
        }
        if (!is_null($limit)) {
            $parameters['limit'] = $limit;
        }
        if (!is_null($start)) {
            $parameters['start'] = $start;
        }
        if (!is_null($sort)) {
            $parameters['sort'] = $sort;
        }
        if (!is_null($dir)) {
            $parameters['dir'] = $dir;
        }

        try {
            $response = $this->questetraClient->get(self::URI_TASK_SEARCH, $parameters);
        } catch (ServiceException $e) {
            if ($e->getResponse()->getStatusCode() == 400) {
                throw $this->createErrorResponseException($e);
            } else {
                throw new \UnexpectedValueException($e->getMessage());
            }
        }

        $data = $this->parseJSONResponse($response);
        if (!array_key_exists('workitems', $data)) {
            throw new \UnexpectedValueException(sprintf("The key 'workitems' is not found in the data that is returned from [ %s ].",
                self::URI_TASK_SEARCH
            ));
        }
        if (!is_array($data['workitems'])) {
            throw new \UnexpectedValueException("The value of the key 'workitems' is not an array.");
        }

        $workitems = array();
        foreach ($data['workitems'] as $workitem) {
            $workitemEntry = new WorkitemEntry();
            $this->transformToObject($workitem, $workitemEntry);
            $workitems[] = $workitemEntry;
        }

        return $workitems;
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
