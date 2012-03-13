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

use Piece\Questetra\API\Response\ActivityEntry;
use Piece\Questetra\API\Response\WorkitemEntry;
use Piece\Questetra\Core\ServiceException;

/**
 * @package    Piece_Questetra
 * @copyright  2012 KUBO Atsuhiro <kubo@iteman.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version    Release: @package_version@
 * @since      Class available since Release 0.1.0
 */
class ProcessExecution extends API
{
    const URI_STARTABLE_ACTIVITIES = 'API/PE/ProcessModel/list';
    const URI_PROCESS_START = 'API/PE/ProcessInstance/start';
    const URI_TASK_EXECUTION = 'API/PE/Workitem/Form/save';

    /**
     * @return array
     * @throws \Piece\Questetra\API\ErrorResponseException
     * @throws \UnexpectedValueException
     */
    public function getStartableActivities()
    {
        try {
            $response = $this->questetraClient->get(self::URI_STARTABLE_ACTIVITIES);
        } catch (ServiceException $e) {
            if ($e->getResponse()->getStatusCode() == 400) {
                throw $this->createErrorResponseException($e);
            } else {
                throw new \UnexpectedValueException($e->getMessage());
            }
        }

        $data = $this->parseJSONResponse($response);
        if (!array_key_exists('startableActivities', $data)) {
            throw new \UnexpectedValueException(sprintf("The key 'startableActivities' is not found in the data that is returned from [ %s ].",
                self::URI_STARTABLE_ACTIVITIES
            ));
        }
        if (!is_array($data['startableActivities'])) {
            throw new \UnexpectedValueException("The value of the key 'startableActivities' is not an array.");
        }

        $activities = array();
        foreach ($data['startableActivities'] as $startableActivity) {
            $activityEntry = new ActivityEntry();
            $this->transformToObject($startableActivity, $activityEntry);
            $activities[] = $activityEntry;
        }

        return $activities;
    }

    /**
     * @param string $processModelName
     * @return array
     */
    public function findStartableActivities($processModelName)
    {
        return array_values(array_filter($this->getStartableActivities(), function (ActivityEntry $startableActivity) use ($processModelName) {
            return $startableActivity->getProcessModelInfoName() == $processModelName;
        }));
    }

    /**
     * @param string $processModelName
     * @param string $taskName
     * @return \Piece\Questetra\API\Response\ActivityEntry
     * @throws \UnexpectedValueException
     */
    public function findStartableActivity($processModelName, $taskName)
    {
        $startableActivities = array_filter($this->findStartableActivities($processModelName), function (ActivityEntry $startableActivity) use ($taskName) {
            return $startableActivity->getNodeName() == $taskName;
        });
        switch (count($startableActivities)) {
        case 0:
            return null;
        case 1:
            return current($startableActivities);
        default:
            throw new \UnexpectedValueException(sprintf('Multiple startable activities are found for the process model [ %s ] and task [ %s ]. The startable task names should be unique.',
                $processModelName,
                $taskName
            ));
        }
    }

    /**
     * @param \Piece\Questetra\API\Response\ActivityEntry $activityEntry
     * @return \Piece\Questetra\API\Response\WorkitemEntry
     * @throws \Piece\Questetra\API\ErrorResponseException
     * @throws \UnexpectedValueException
     */
    public function startProcess(ActivityEntry $activityEntry)
    {
        try {
            $response = $this->questetraClient->post(self::URI_PROCESS_START, array(
                'activityId' => $activityEntry->getId()
            ));
        } catch (ServiceException $e) {
            if ($e->getResponse()->getStatusCode() == 400) {
                throw $this->createErrorResponseException($e);
            } else {
                throw new \UnexpectedValueException($e->getMessage());
            }
        }

        $data = $this->parseJSONResponse($response);
        if (!array_key_exists('workitem', $data)) {
            throw new \UnexpectedValueException(sprintf("The key 'workitem' is not found in the data that is returned from [ %s ].",
                self::URI_PROCESS_START
            ));
        }
        if (!is_array($data['workitem'])) {
            throw new \UnexpectedValueException("The value of the key 'workitem' is not an array.");
        }

        $workitemEntry = new WorkitemEntry();
        $this->transformToObject($data['workitem'], $workitemEntry);

        return $workitemEntry;
    }

    /**
     * @param \Piece\Questetra\API\Response\WorkitemEntry $workitemEntry
     * @param array $parameters
     * @throws \Piece\Questetra\API\TaskExecutionException
     * @throws \UnexpectedValueException
     */
    public function executeTask(WorkitemEntry $workitemEntry, array $parameters)
    {
        $parameters['workitemId'] = $workitemEntry->getId();

        try {
            $this->questetraClient->post(self::URI_TASK_EXECUTION, $parameters);
        } catch (ServiceException $e) {
            if ($e->getResponse()->getStatusCode() == 500) {
                throw $this->createTaskExecutionException($e);
            } else {
                throw new \UnexpectedValueException($e->getMessage());
            }
        }
    }

    /**
     * @param \use Piece\Questetra\Core\ServiceException $e
     * @return \Piece\Questetra\API\TaskExecutionException
     * @throws \UnexpectedValueException
     */
    protected function createTaskExecutionException(ServiceException $serviceException)
    {
        $data = $this->parseXMLResponse($serviceException->getResponse());

        $processDataValidationErrors = array();
        foreach ($data->xpath('//process-data-validation-errors/error') as $error) {
            $processDataValidationErrors[ (string) $error->key ] = (string) $error->detail;
        }

        $errors = array();
        foreach ($data->xpath('//errors/error') as $error) {
            $errors[ (string) $error->key ] = (string) $error->detail;
        }

        $taskExecutionException = new TaskExecutionException($serviceException->getMessage());
        $taskExecutionException->setRequestContext($serviceException->getRequestContext());
        $taskExecutionException->setRequest($serviceException->getRequest());
        $taskExecutionException->setResponse($serviceException->getResponse());
        $taskExecutionException->setProcessDataValidationErrors($processDataValidationErrors);
        $taskExecutionException->setErrors($errors);
        return $taskExecutionException;
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
