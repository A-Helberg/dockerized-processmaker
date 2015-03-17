<?php
namespace ProcessMaker\BusinessModel;

use \G;

class CaseScheduler
{
    /**
     * Return case scheduler of a project
     * @param string $sProcessUID
     * @return array
     *
     * @access public
     */
    public function getCaseSchedulers($sProcessUID = '')
    {
        try {
            $oCriteria = new \Criteria( 'workflow' );
            $oCriteria->clearSelectColumns();
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_UID );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_NAME );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_DEL_USER_NAME );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_DEL_USER_UID );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::PRO_UID );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::TAS_UID );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_TIME_NEXT_RUN );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_LAST_RUN_TIME );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_STATE );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_LAST_STATE );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::USR_UID );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_OPTION );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_START_TIME );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_START_DATE );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_DAYS_PERFORM_TASK );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_EVERY_DAYS );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_WEEK_DAYS );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_START_DAY );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_MONTHS );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_END_DATE );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_REPEAT_EVERY );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_REPEAT_UNTIL );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_REPEAT_STOP_IF_RUNNING );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::CASE_SH_PLUGIN_UID );
            $oCriteria->add( \CaseSchedulerPeer::PRO_UID, $sProcessUID );
            $oDataset = \CaseSchedulerPeer::doSelectRS( $oCriteria );
            $oDataset->setFetchmode( \ResultSet::FETCHMODE_ASSOC );
            $oDataset->next();
            $aRows = array();
            while ($aRow = $oDataset->getRow()) {
                $aRow = array_change_key_case($aRow, CASE_LOWER);
                $aRows[] = $aRow;
                $oDataset->next();
            }
            return $aRows;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Return case scheduler of a project
     * @param string $sProcessUID
     * @param string $sCaseSchedulerUID
     * @return array
     *
     * @access public
     */
    public function getCaseScheduler($sProcessUID = '', $sCaseSchedulerUID = '')
    {
        try {
            $oCaseSchedulerTest = \CaseSchedulerPeer::retrieveByPK( $sCaseSchedulerUID );
            if (is_null($oCaseSchedulerTest)) {
                throw new \Exception(\G::LoadTranslation("ID_CASE_SCHEDULER_DOES_NOT_EXIST", array($sCaseSchedulerUID)));
            }
            $oCriteria = new \Criteria( 'workflow' );
            $oCriteria->clearSelectColumns();
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_UID );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_NAME );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_DEL_USER_NAME );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_DEL_USER_UID );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::PRO_UID );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::TAS_UID );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_TIME_NEXT_RUN );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_LAST_RUN_TIME );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_STATE );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_LAST_STATE );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::USR_UID );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_OPTION );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_START_TIME );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_START_DATE );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_DAYS_PERFORM_TASK );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_EVERY_DAYS );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_WEEK_DAYS );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_START_DAY );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_MONTHS );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_END_DATE );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_REPEAT_EVERY );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_REPEAT_UNTIL );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::SCH_REPEAT_STOP_IF_RUNNING );
            $oCriteria->addSelectColumn( \CaseSchedulerPeer::CASE_SH_PLUGIN_UID );
            $oCriteria->add( \CaseSchedulerPeer::PRO_UID, $sProcessUID );
            $oCriteria->add( \CaseSchedulerPeer::SCH_UID, $sCaseSchedulerUID );
            $oDataset = \CaseSchedulerPeer::doSelectRS( $oCriteria );
            $oDataset->setFetchmode( \ResultSet::FETCHMODE_ASSOC );
            $oDataset->next();
            $aRows = array();
            while ($aRow = $oDataset->getRow()) {
                $aRow = array_change_key_case($aRow, CASE_LOWER);
                $aRows = $aRow;
                $oDataset->next();
            }
            return $aRows;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Get data of unique ids of a Task (Unique id of Process)
     *
     * @param string $taskUid Unique id of Task
     *
     * return array
     */
    public function getTaskUid($taskUid)
    {
        try {
            $criteria = new \Criteria("workflow");
            $criteria->addSelectColumn(\TaskPeer::TAS_UID);
            $criteria->add(\TaskPeer::TAS_UID, $taskUid, \Criteria::EQUAL);
            $rsCriteria = \TaskPeer::doSelectRS($criteria);
            $rsCriteria->setFetchmode(\ResultSet::FETCHMODE_ASSOC);
            $rsCriteria->next();
            return $rsCriteria->getRow();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Checks if the name exists in the case Scheduler
     *
     * @param string $processUid Unique id of Process
     * @param string $name       Name
     *
     * return bool Return true if the name exists, false otherwise
     */
    public function existsName($processUid, $name)
    {
        try {
            $criteria = new \Criteria("workflow");
            $criteria->addSelectColumn(\CaseSchedulerPeer::TAS_UID);
            $criteria->add(\CaseSchedulerPeer::SCH_NAME, $name, \Criteria::EQUAL);
            $criteria->add(\CaseSchedulerPeer::PRO_UID, $processUid, \Criteria::EQUAL);
            $rsCriteria = \CaseSchedulerPeer::doSelectRS($criteria);
            $rsCriteria->setFetchmode(\ResultSet::FETCHMODE_ASSOC);
            $rsCriteria->next();
            return $rsCriteria->getRow();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Checks if the name exists in the case Scheduler
     *
     * @param string $processUid Unique id of Process
     * @param string $name       Name
     *
     * return bool Return true if the name exists, false otherwise
     */
    public function existsNameUpdate($processUid, $schUid, $name)
    {
        try {
            $criteria = new \Criteria("workflow");
            $criteria->addSelectColumn(\CaseSchedulerPeer::TAS_UID);
            $criteria->add(\CaseSchedulerPeer::SCH_NAME, $name, \Criteria::EQUAL);
            $criteria->add(\CaseSchedulerPeer::SCH_UID, $schUid, \Criteria::NOT_EQUAL);
            $criteria->add(\CaseSchedulerPeer::PRO_UID, $processUid, \Criteria::EQUAL);
            $rsCriteria = \CaseSchedulerPeer::doSelectRS($criteria);
            $rsCriteria->setFetchmode(\ResultSet::FETCHMODE_ASSOC);
            $rsCriteria->next();
            return $rsCriteria->getRow();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Checks if the user exists
     *
     * @param string $userName  Name
     * @param string $sTaskUID  Task
     *
     * return message
     */
    public function getUser($userName, $sTaskUID)
    {
        try {
            $sTASKS = $sTaskUID;
            $sWS_USER = trim( $userName );
            $oCriteria = new \Criteria( 'workflow' );
            $oCriteria->addSelectColumn( \UsersPeer::USR_UID );
            $oCriteria->addSelectColumn( \TaskUserPeer::USR_UID );
            $oCriteria->addSelectColumn( \TaskUserPeer::TAS_UID );
            $oCriteria->addSelectColumn( \UsersPeer::USR_USERNAME );
            $oCriteria->addSelectColumn( \UsersPeer::USR_FIRSTNAME );
            $oCriteria->addSelectColumn( \UsersPeer::USR_LASTNAME );
            $oCriteria->addJoin( \TaskUserPeer::USR_UID, \UsersPeer::USR_UID, \Criteria::LEFT_JOIN );
            $oCriteria->add( \TaskUserPeer::TAS_UID, $sTASKS );
            $oCriteria->add( \UsersPeer::USR_USERNAME, $sWS_USER );
            $userIsAssigned = \TaskUserPeer::doCount( $oCriteria );
            if ($userIsAssigned < 1) {
                $oCriteria = new \Criteria( 'workflow' );
                $oCriteria->addSelectColumn( \UsersPeer::USR_UID );
                $oCriteria->addJoin( \UsersPeer::USR_UID, \GroupUserPeer::USR_UID, \Criteria::LEFT_JOIN );
                $oCriteria->addJoin( \GroupUserPeer::GRP_UID, \TaskUserPeer::USR_UID, \Criteria::LEFT_JOIN );
                $oCriteria->add( \TaskUserPeer::TAS_UID, $sTASKS );
                $oCriteria->add( \UsersPeer::USR_USERNAME, $sWS_USER );
                $userIsAssigned = \GroupUserPeer::doCount( $oCriteria );
                if (! ($userIsAssigned >= 1)) {
                    throw new \Exception(\G::LoadTranslation("ID_USER_DOES_NOT_HAVE_ACTIVITY_ASSIGNED", array($sWS_USER, $sTASKS)));
                }
            }
            $oDataset = \TaskUserPeer::doSelectRS($oCriteria);
            $oDataset->setFetchmode(\ResultSet::FETCHMODE_ASSOC);
            $oDataset->next();
            while ($aRow = $oDataset->getRow()) {
                $messageCode = $aRow['USR_UID'];
                $oDataset->next();
            }
            return $messageCode;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Create a new case scheduler of a project
     * @param string $sProcessUID
     * @param array  $caseSchedulerData
     * @param string $userUID
     * @return array
     *
     * @access public
     */
    public function addCaseScheduler($sProcessUID, $caseSchedulerData, $userUID)
    {
        try {
            require_once(PATH_TRUNK . "workflow" . PATH_SEP . "engine" . PATH_SEP . "classes" . PATH_SEP . "model" . PATH_SEP . "CaseScheduler.php");
            $caseSchedulerData['sch_repeat_stop_if_running'] = '0';
            $caseSchedulerData['case_sh_plugin_uid'] = null;
            $caseSchedulerData = array_change_key_case($caseSchedulerData, CASE_UPPER);
            $sOption = $caseSchedulerData['SCH_OPTION'];
            if (empty($caseSchedulerData)) {
                die( \G::LoadTranslation("ID_INFORMATION_EMPTY") );
            }
            $arrayTaskUid = $this->getTaskUid($caseSchedulerData['TAS_UID']);
            if (empty($arrayTaskUid)) {
                throw (new \Exception( \G::LoadTranslation("ID_TASK_NOT_FOUND", array($caseSchedulerData['TAS_UID']))));
            }
            if ($caseSchedulerData['SCH_NAME']=='') {
                throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_EMPTY", array ('sch_name')));
            }
            if ($this->existsName($sProcessUID, $caseSchedulerData['SCH_NAME'])) {
                throw new \Exception(\G::LoadTranslation("ID_CASE_SCHEDULER_DUPLICATE"));
            }
            $mUser = $this->getUser($caseSchedulerData['SCH_DEL_USER_NAME'], $caseSchedulerData['TAS_UID']);
            $oUser = \UsersPeer::retrieveByPK( $mUser );
            if (is_null($oUser)) {
                throw (new \Exception($mUser));
            }
            $oUserPass = $oUser->getUsrPassword();
            $caseSchedulerData['SCH_DEL_USER_PASS'] = $oUserPass;
            if ($sOption != '5') {
                $pattern="/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])$/";
                if (!preg_match($pattern, $caseSchedulerData['SCH_START_TIME'])) {
                    throw new \Exception(\G::LoadTranslation("ID_INVALID_SCH_START_TIME"));
                }
            }
            $patternDate="/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/";
            if ($sOption == '1' || $sOption == '2' || $sOption == '3') {
                if (!preg_match($patternDate, $caseSchedulerData['SCH_START_DATE'])) {
                    throw new \Exception(\G::LoadTranslation("ID_INVALID_SCH_START_DATE"));
                }
                if ($caseSchedulerData['SCH_START_DATE'] == "") {
                    throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_start_date')));
                }
            }
            if ($sOption == '2') {
                $caseSchedulerData['SCH_EVERY_DAYS'] = 1;
            } else {
                $caseSchedulerData['SCH_EVERY_DAYS'] = 0;
            }
            $oCaseScheduler = new \CaseScheduler();
            $caseSchedulerData['SCH_UID'] = \G::generateUniqueID();
            $caseSchedulerData['PRO_UID'] = $sProcessUID;
            $caseSchedulerData['SCH_STATE'] = 'ACTIVE';
            $caseSchedulerData['SCH_LAST_STATE'] = 'CREATED'; // 'ACTIVE';
            $caseSchedulerData['USR_UID'] = $userUID;
            $caseSchedulerData['SCH_DEL_USER_UID'] = $caseSchedulerData['USR_UID'];
            $sTimeTmp = $caseSchedulerData['SCH_START_TIME'];
            $nActualTime = $caseSchedulerData['SCH_START_TIME']; // time();
            $sValue = '';
            $sDaysPerformTask = '';
            $sWeeks = '';
            $sMonths = '';
            $sStartDay = '';
            $caseSchedulerData['SCH_DAYS_PERFORM_TASK'] = '';
            switch ($sOption) {
                case '1': // If the option is zero, set by default 1
                    $caseSchedulerData['SCH_DAYS_PERFORM_TASK'] = '1';
                    $sValue = $caseSchedulerData['SCH_DAYS_PERFORM_TASK'];
                    switch ($sValue) {
                        case '1':
                            $caseSchedulerData['SCH_DAYS_PERFORM_TASK'] = $caseSchedulerData['SCH_DAYS_PERFORM_TASK'] . '|1';
                            $caseSchedulerData['SCH_MONTHS'] ='0|0|0|0|0|0|0|0|0|0|0|0';
                            $caseSchedulerData['SCH_WEEK_DAYS'] ='0|0|0|0|0|0|0';
                            break;
                        case '2':
                            $caseSchedulerData['SCH_OPTION'] = '2';
                            $caseSchedulerData['SCH_EVERY_DAYS'] = '1'; //check
                            $caseSchedulerData['SCH_WEEK_DAYS'] = '1|2|3|4|5|'; //check
                            break;
                        case '3': // Every [n] Days
                            $sDaysPerformTask = $caseSchedulerData['SCH_DAYS_PERFORM_TASK'];
                            $caseSchedulerData['SCH_DAYS_PERFORM_TASK'] = $caseSchedulerData['SCH_DAYS_PERFORM_TASK'];
                            break;
                    }
                    break;
                case '2': // If the option is zero, set by default 1
                    if ($caseSchedulerData['SCH_WEEK_DAYS'] == "") {
                        throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_week_days')));
                    } else {
                        $weeks = $caseSchedulerData['SCH_WEEK_DAYS'];
                        $weeks = explode("|", $weeks);
                        foreach ($weeks as $row) {
                            if ($row == "1" || $row == "2" || $row == "3" || $row == "4" || $row == "5"|| $row == "6" || $row == "7") {
                                $caseSchedulerData['SCH_WEEK_DAYS'] = $caseSchedulerData['SCH_WEEK_DAYS'];
                            } else {
                                throw new \Exception(\G::LoadTranslation("ID_INVALID_VALUE_FOR", array('sch_week_days')));
                            }
                        }
                    }
                    $caseSchedulerData['SCH_MONTHS'] ='0|0|0|0|0|0|0|0|0|0|0|0';
                    if (empty( $caseSchedulerData['SCH_EVERY_DAYS'] )) {
                        $nEveryDays = 1;
                    } else {
                        $nEveryDays = $caseSchedulerData['SCH_EVERY_DAYS'];
                    }
                    $caseSchedulerData['SCH_EVERY_DAYS'] = $nEveryDays;
                    if (! empty( $caseSchedulerData['SCH_WEEK_DAYS'] )) {
                        $aWeekDays = $caseSchedulerData['SCH_WEEK_DAYS'];
                    }
                    $sStartTime = $caseSchedulerData['SCH_START_TIME'];
                    $sWeeks = $caseSchedulerData['SCH_WEEK_DAYS'] . '|';
                    break;
                case '3':
                    $nStartDay = $caseSchedulerData['SCH_START_DAY'];
                    if ($nStartDay == "") {
                        throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_start_day')));
                    }
                    if ($nStartDay == 1) {
                        if ($caseSchedulerData['SCH_START_DAY_OPT_1'] == "") {
                            throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_start_day_opt_1')));
                        }
                        $temp = $caseSchedulerData['SCH_START_DAY_OPT_1'];
                        $temp = (int)$temp;
                        if ($temp >= 1 && $temp <= 31) {
                            $caseSchedulerData['SCH_START_DAY_OPT_1'] = $caseSchedulerData['SCH_START_DAY_OPT_1'];
                        } else {
                            throw new \Exception(\G::LoadTranslation("ID_INVALID_SCH_START_DAY_1"));
                        }
                        $caseSchedulerData['SCH_START_DAY'] = $nStartDay . '|' . $caseSchedulerData['SCH_START_DAY_OPT_1'];
                    } else {
                        if ($caseSchedulerData['SCH_START_DAY_OPT_2'] == "") {
                            throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_start_day_opt_2')));
                        }
                        $caseSchedulerData['SCH_START_DAY'] = $nStartDay . '|' . $caseSchedulerData['SCH_START_DAY_OPT_2'];
                        $optionTwo = $caseSchedulerData['SCH_START_DAY_OPT_2']{0};
                        if ($optionTwo == "1" || $optionTwo == "2" || $optionTwo == "3" || $optionTwo == "4" || $optionTwo == "5") {
                            $caseSchedulerData['SCH_START_DAY_OPT_2'] = $caseSchedulerData['SCH_START_DAY_OPT_2'];
                        } else {
                            throw new \Exception(\G::LoadTranslation("ID_INVALID_VALUE_FOR", array('sch_start_day_opt_2')));
                        }
                        $pipelineTwo = $caseSchedulerData['SCH_START_DAY_OPT_2']{1};
                        if ($pipelineTwo == "|") {
                            $caseSchedulerData['SCH_START_DAY_OPT_2'] = $caseSchedulerData['SCH_START_DAY_OPT_2'];
                        } else {
                            throw new \Exception(\G::LoadTranslation("ID_INVALID_VALUE_FOR", array('sch_start_day_opt_2')));
                        }
                        $dayTwo = $caseSchedulerData['SCH_START_DAY_OPT_2']{2};
                        if ($dayTwo == "1" || $dayTwo == "2" || $dayTwo == "3" || $dayTwo == "4" || $dayTwo == "5" || $dayTwo == "6" || $dayTwo == "7") {
                            $caseSchedulerData['SCH_START_DAY_OPT_2'] = $caseSchedulerData['SCH_START_DAY_OPT_2'];
                        } else {
                            throw new \Exception(\G::LoadTranslation("ID_INVALID_VALUE_FOR", array('sch_start_day_opt_2')));
                        }
                    }
                    if ($nStartDay == "") {
                        throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_start_day')));
                    }
                    if ($caseSchedulerData['SCH_MONTHS'] == "") {
                        throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_months')));
                    }
                    if (! empty( $caseSchedulerData['SCH_MONTHS'] )) {
                        $aMonths = $caseSchedulerData['SCH_MONTHS'];
                        $aMonths = explode("|", $aMonths);
                        foreach ($aMonths as $row) {
                            if ($row == "1" || $row == "2" || $row == "3" || $row == "4" || $row == "5"|| $row == "6" || $row == "7"|| $row == "8" || $row == "9" || $row == "10"|| $row == "11" || $row == "12") {
                                $caseSchedulerData['SCH_MONTHS'] = $caseSchedulerData['SCH_MONTHS'];
                            } else {
                                throw new \Exception(\G::LoadTranslation("ID_INVALID_VALUE_FOR", array('sch_months')));
                            }
                        }
                    }
                    $sMonths = $caseSchedulerData['SCH_MONTHS'];
                    $sStartDay = $caseSchedulerData['SCH_START_DAY'];
                    $sValue = $nStartDay;
                    break;
            }
            if (($sOption != '1') && ($sOption != '4') && ($sOption != '5')) {
                $sDateTmp = '';
                if ($sStartDay == '') {
                    $sStartDay = date('Y-m-d');
                } else {
                    $size = strlen($caseSchedulerData['SCH_START_DAY']);
                    if ($size > 4) {
                        $aaStartDay = explode( "|", $caseSchedulerData['SCH_START_DAY'] );
                        $aaStartDay[0] = $aaStartDay[0];
                        $aaStartDay[1] = $aaStartDay[1];
                        $aaStartDay[2]= ($aaStartDay[2] == 7 ? 1 : $aaStartDay[2]);
                        $sStartDay = $aaStartDay[0].'|'.$aaStartDay[1].'|'.$aaStartDay[2];
                    }
                }
                $dCurrentDay = date("d");
                $dCurrentMonth = date("m");
                $aStartDay = explode( "|", $caseSchedulerData['SCH_START_DAY'] );
                if ($sOption == '3' && $aStartDay[0] == '1') {
                    $monthsArray = explode( "|", $sMonths );
                    foreach ($monthsArray as $row) {
                        if ($dCurrentMonth == $row && $dCurrentDay < $aStartDay[1]) {
                            $startTime = $caseSchedulerData['SCH_START_TIME'] . ":00";
                            $caseSchedulerData['SCH_TIME_NEXT_RUN'] = date('Y') . '-' . $row . '-' . $aStartDay[1] . ' ' . $startTime;
                            break;
                        } else {
                            $caseSchedulerData['SCH_TIME_NEXT_RUN'] = $oCaseScheduler->updateNextRun( $sOption, $sValue, $nActualTime, $sDaysPerformTask, $sWeeks, $sStartDay, $sMonths, $sDateTmp );
                        }
                    }
                } else {
                    $caseSchedulerData['SCH_TIME_NEXT_RUN'] = $oCaseScheduler->updateNextRun( $sOption, $sValue, $nActualTime, $sDaysPerformTask, $sWeeks, $sStartDay, $sMonths, $sDateTmp );
                }
            } else {
                if ($sOption == '4') {
                    $sDateTmp = date('Y-m-d');
                    $caseSchedulerData['SCH_START_TIME'] = date('Y-m-d', strtotime( $sDateTmp )) . ' ' . date('H:i:s', strtotime( $sTimeTmp ));
                    $caseSchedulerData['SCH_START_DATE'] = $caseSchedulerData['SCH_START_TIME'];
                    $caseSchedulerData['SCH_END_DATE'] = $caseSchedulerData['SCH_START_TIME'];
                }
                $caseSchedulerData['SCH_TIME_NEXT_RUN'] = $caseSchedulerData['SCH_START_TIME'];
                if ($sOption == '5') {
                    if ($caseSchedulerData['SCH_START_DATE'] != '') {
                        $sDateTmp = $caseSchedulerData['SCH_START_DATE'];
                    } else {
                        $sDateTmp = date('Y-m-d');
                        $caseSchedulerData['SCH_START_DATE'] = $sDateTmp;
                    }
                    $caseSchedulerData['SCH_START_TIME'] = time();
                    $caseSchedulerData['SCH_START_DATE'] = $caseSchedulerData['SCH_START_TIME'];
                    if ($caseSchedulerData['SCH_REPEAT_EVERY'] == "") {
                        throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_repeat_every')));
                    }
                    $patternHour="/^([0-9]|0[0-9]|1[0-9]|2[0-3]).[0-5][0-9]$/";
                    if (!preg_match($patternHour, $caseSchedulerData['SCH_REPEAT_EVERY'])) {
                        throw new \Exception(\G::LoadTranslation("ID_INVALID_SCH_REPEAT"));
                    }
                    $nextRun = $caseSchedulerData['SCH_REPEAT_EVERY'] * 60 * 60;
                    $caseSchedulerData['SCH_REPEAT_EVERY'] = $caseSchedulerData['SCH_REPEAT_EVERY'];
                    $date = $caseSchedulerData['SCH_START_TIME'];
                    $date += $nextRun;
                    $date = date("Y-m-d H:i", $date);
                    $caseSchedulerData['SCH_TIME_NEXT_RUN'] = $date;
                }
            }
            if (! empty( $caseSchedulerData['SCH_REPEAT_TASK_CHK'] )) {
                if (trim( $caseSchedulerData['SCH_END_DATE'] ) != '') {
                    $caseSchedulerData['SCH_END_DATE'] = $caseSchedulerData['SCH_END_DATE'];
                }
            }
            if (! empty( $caseSchedulerData['SCH_REPEAT_TASK_CHK'] )) {
                $nOptEvery = $caseSchedulerData['SCH_REPEAT_EVERY_OPT'];
                if ($nOptEvery == 2) {
                    $caseSchedulerData['SCH_REPEAT_EVERY'] = $caseSchedulerData['SCH_REPEAT_EVERY'] * 60;
                } else {
                    $caseSchedulerData['SCH_REPEAT_EVERY'] = $caseSchedulerData['SCH_REPEAT_EVERY'];
                }
            }
            if ((isset( $caseSchedulerData['CASE_SH_PLUGIN_UID'] )) && ($caseSchedulerData['CASE_SH_PLUGIN_UID'] != "")) {
                $caseSchedulerData['CASE_SH_PLUGIN_UID'] = $caseSchedulerData['CASE_SH_PLUGIN_UID'];
            }
            // check this data
            $caseSchedulerData['SCH_REPEAT_UNTIL'] = '';
            $caseSchedulerData['SCH_REPEAT_STOP_IF_RUNNING'] = '0';
            $caseSchedulerData['CASE_SH_PLUGIN_UID'] = null;
            //
            $oCaseScheduler->create( $caseSchedulerData );
            $oCriteria = $this->getCaseScheduler($sProcessUID, $caseSchedulerData['SCH_UID']);
            return $oCriteria;
        } catch (Exception $oException) {
            die( $oException->getMessage() );
        }
    }

    /**
     * Update case scheduler for a project
     * @param string $sProcessUID
     * @param array  $caseSchedulerData
     * @param string $userUID
     * @param string $sSchUID
     *
     * @access public
     */
    public function updateCaseScheduler($sProcessUID, $caseSchedulerData, $userUID, $sSchUID = '')
    {
        try {
            require_once(PATH_TRUNK . "workflow" . PATH_SEP . "engine" . PATH_SEP . "classes" . PATH_SEP . "model" . PATH_SEP . "CaseScheduler.php");
            $caseSchedulerData = array_change_key_case($caseSchedulerData, CASE_UPPER);
            if (empty( $caseSchedulerData )) {
                die( \G::LoadTranslation("ID_INFORMATION_EMPTY") );
            }
            $oCaseScheduler = new \CaseScheduler();
            $aFields = $oCaseScheduler->Load($sSchUID);
            if ($caseSchedulerData['SCH_OPTION'] == null) {
                $sOption = $aFields['SCH_OPTION'];
                $caseSchedulerData['SCH_OPTION'] = $sOption;
            } else {
                $sOption = $caseSchedulerData['SCH_OPTION'];
            }
            $caseSchedulerData['sch_repeat_stop_if_running'] = '0';
            $caseSchedulerData['case_sh_plugin_uid'] = null;
            $caseSchedulerData = array_change_key_case($caseSchedulerData, CASE_UPPER);
            $arrayTaskUid = $this->getTaskUid($caseSchedulerData['TAS_UID']);
            if (empty($arrayTaskUid)) {
                throw new \Exception(\G::LoadTranslation("ID_TASK_NOT_FOUND", array($caseSchedulerData['TAS_UID'])));
            }
            if ($caseSchedulerData['SCH_NAME']=='') {
                throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_EMPTY", array ('sch_name')));
            }
            if ($this->existsNameUpdate($sProcessUID, $sSchUID, $caseSchedulerData['SCH_NAME'])) {
                throw new \Exception(\G::LoadTranslation("ID_CASE_SCHEDULER_DUPLICATE"));
            }
            $mUser = $this->getUser($caseSchedulerData['SCH_DEL_USER_NAME'], $caseSchedulerData['TAS_UID']);
            $oUser = \UsersPeer::retrieveByPK( $mUser );
            if (is_null($oUser)) {
                throw (new \Exception($mUser));
            }
            $oUserPass = $oUser->getUsrPassword();
            $caseSchedulerData['SCH_DEL_USER_PASS'] = $oUserPass;
            if ($sOption != '5') {
                $pattern="/^([0-1][0-9]|[2][0-3])[\:]([0-5][0-9])$/";
                if (!preg_match($pattern, $caseSchedulerData['SCH_START_TIME'])) {
                    throw new \Exception(\G::LoadTranslation("ID_INVALID_SCH_START_TIME"));
                }
            }
            $patternDate="/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/";
            if ($sOption == '1' || $sOption == '2' || $sOption == '3') {
                if (!preg_match($patternDate, $caseSchedulerData['SCH_START_DATE'])) {
                    throw new \Exception(\G::LoadTranslation("ID_INVALID_SCH_START_DATE"));
                }
                if ($caseSchedulerData['SCH_START_DATE'] == "") {
                    throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_start_date')));
                }
            }
            if ($sOption == '2') {
                $caseSchedulerData['SCH_EVERY_DAYS'] = 1;
            } else {
                $caseSchedulerData['SCH_EVERY_DAYS'] = 0;
            }
            $oCaseScheduler = new \CaseScheduler();
            $caseSchedulerData['SCH_UID'] = $sSchUID;
            $caseSchedulerData['PRO_UID'] = $sProcessUID;
            if ($caseSchedulerData['SCH_STATE'] == "" || $caseSchedulerData['SCH_STATE'] == null) {
                throw (new \Exception( 'sch_state can not be null'));
            } else {
                if ($caseSchedulerData['SCH_STATE']  == 'ACTIVE') {
                    $caseSchedulerData['SCH_LAST_STATE']  = 'CREATED';
                } else {
                    $caseSchedulerData['SCH_LAST_STATE'] = 'ACTIVE';
                }
            }
            $caseSchedulerData['USR_UID'] = $userUID;
            $caseSchedulerData['SCH_DEL_USER_UID'] = $caseSchedulerData['USR_UID'];
            $sTimeTmp = $caseSchedulerData['SCH_START_TIME'];
            $nActualTime = $caseSchedulerData['SCH_START_TIME']; // time();
            $sValue = '';
            $sDaysPerformTask = '';
            $sWeeks = '';
            $sMonths = '';
            $sStartDay = '';
            $caseSchedulerData['SCH_DAYS_PERFORM_TASK'] = '';
            switch ($sOption) {
                case '1': // If the option is zero, set by default 1
                    $caseSchedulerData['SCH_DAYS_PERFORM_TASK'] = '1';
                    $sValue = $caseSchedulerData['SCH_DAYS_PERFORM_TASK'];
                    switch ($sValue) {
                        case '1':
                            $caseSchedulerData['SCH_DAYS_PERFORM_TASK'] = $caseSchedulerData['SCH_DAYS_PERFORM_TASK'] . '|1';
                            $caseSchedulerData['SCH_MONTHS'] ='0|0|0|0|0|0|0|0|0|0|0|0';
                            $caseSchedulerData['SCH_WEEK_DAYS'] ='0|0|0|0|0|0|0';
                            break;
                        case '2':
                            $caseSchedulerData['SCH_OPTION'] = '2';
                            $caseSchedulerData['SCH_EVERY_DAYS'] = '1'; //check
                            $caseSchedulerData['SCH_WEEK_DAYS'] = '1|2|3|4|5|'; //check
                            break;
                        case '3': // Every [n] Days
                            $sDaysPerformTask = $caseSchedulerData['SCH_DAYS_PERFORM_TASK'];
                            $caseSchedulerData['SCH_DAYS_PERFORM_TASK'] = $caseSchedulerData['SCH_DAYS_PERFORM_TASK'];
                            break;
                    }
                    break;
                case '2': // If the option is zero, set by default 1
                    if ($caseSchedulerData['SCH_WEEK_DAYS'] == "") {
                        throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_week_days')));
                    } else {
                        $weeks = $caseSchedulerData['SCH_WEEK_DAYS'];
                        $weeks = explode("|", $weeks);
                        foreach ($weeks as $row) {
                            if ($row == "1" || $row == "2" || $row == "3" || $row == "4" || $row == "5"|| $row == "6" || $row == "7") {
                                $caseSchedulerData['SCH_WEEK_DAYS'] = $caseSchedulerData['SCH_WEEK_DAYS'];
                            } else {
                                throw new \Exception(\G::LoadTranslation("ID_INVALID_VALUE_FOR", array('sch_week_days')));
                            }
                        }
                    }
                    $caseSchedulerData['SCH_MONTHS'] ='0|0|0|0|0|0|0|0|0|0|0|0';
                    if (empty( $caseSchedulerData['SCH_EVERY_DAYS'] )) {
                        $nEveryDays = 1;
                    } else {
                        $nEveryDays = $caseSchedulerData['SCH_EVERY_DAYS'];
                    }
                    $caseSchedulerData['SCH_EVERY_DAYS'] = $nEveryDays;
                    if (! empty( $caseSchedulerData['SCH_WEEK_DAYS'] )) {
                        $aWeekDays = $caseSchedulerData['SCH_WEEK_DAYS'];
                    }
                    $sStartTime = $caseSchedulerData['SCH_START_TIME'];
                    $sWeeks = $caseSchedulerData['SCH_WEEK_DAYS'] . '|';
                    break;
                case '3':
                    $nStartDay = $caseSchedulerData['SCH_START_DAY'];
                    if ($nStartDay == "") {
                        throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_start_day')));
                    }
                    if ($nStartDay == 1) {
                        if ($caseSchedulerData['SCH_START_DAY_OPT_1'] == "") {
                            throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_start_day_opt_1')));
                        }
                        $temp = $caseSchedulerData['SCH_START_DAY_OPT_1'];
                        $temp = (int)$temp;
                        if ($temp >= 1 && $temp <= 31) {
                            $caseSchedulerData['SCH_START_DAY_OPT_1'] = $caseSchedulerData['SCH_START_DAY_OPT_1'];
                        } else {
                            throw new \Exception(\G::LoadTranslation("ID_INVALID_SCH_START_DAY_1"));
                        }
                        $caseSchedulerData['SCH_START_DAY'] = $nStartDay . '|' . $caseSchedulerData['SCH_START_DAY_OPT_1'];
                    } else {
                        if ($caseSchedulerData['SCH_START_DAY_OPT_2'] == "") {
                            throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_start_day_opt_2')));
                        }
                        $caseSchedulerData['SCH_START_DAY'] = $nStartDay . '|' . $caseSchedulerData['SCH_START_DAY_OPT_2'];
                        $optionTwo = $caseSchedulerData['SCH_START_DAY_OPT_2']{0};
                        if ($optionTwo == "1" || $optionTwo == "2" || $optionTwo == "3" || $optionTwo == "4" || $optionTwo == "5") {
                            $caseSchedulerData['SCH_START_DAY_OPT_2'] = $caseSchedulerData['SCH_START_DAY_OPT_2'];
                        } else {
                            throw new \Exception(\G::LoadTranslation("ID_INVALID_VALUE_FOR", array('sch_start_day_opt_2')));
                        }
                        $pipelineTwo = $caseSchedulerData['SCH_START_DAY_OPT_2']{1};
                        if ($pipelineTwo == "|") {
                            $caseSchedulerData['SCH_START_DAY_OPT_2'] = $caseSchedulerData['SCH_START_DAY_OPT_2'];
                        } else {
                            throw new \Exception(\G::LoadTranslation("ID_INVALID_VALUE_FOR", array('sch_start_day_opt_2')));
                        }
                        $dayTwo = $caseSchedulerData['SCH_START_DAY_OPT_2']{2};
                        if ($dayTwo == "1" || $dayTwo == "2" || $dayTwo == "3" || $dayTwo == "4" || $dayTwo == "5" || $dayTwo == "6" || $dayTwo == "7") {
                            $caseSchedulerData['SCH_START_DAY_OPT_2'] = $caseSchedulerData['SCH_START_DAY_OPT_2'];
                        } else {
                            throw new \Exception(\G::LoadTranslation("ID_INVALID_VALUE_FOR", array('sch_start_day_opt_2')));
                        }
                    }
                    if ($nStartDay == "") {
                        throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_start_day')));
                    }
                    if ($caseSchedulerData['SCH_MONTHS'] == "") {
                        throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_months')));
                    }
                    if (! empty( $caseSchedulerData['SCH_MONTHS'] )) {
                        $aMonths = $caseSchedulerData['SCH_MONTHS'];
                        $aMonths = explode("|", $aMonths);
                        foreach ($aMonths as $row) {
                            if ($row == "1" || $row == "2" || $row == "3" || $row == "4" || $row == "5"|| $row == "6" || $row == "7"|| $row == "8" || $row == "9" || $row == "10"|| $row == "11" || $row == "12") {
                                $caseSchedulerData['SCH_MONTHS'] = $caseSchedulerData['SCH_MONTHS'];
                            } else {
                                throw new \Exception(\G::LoadTranslation("ID_INVALID_VALUE_FOR", array('sch_months')));
                            }
                        }
                    }
                    $sMonths = $caseSchedulerData['SCH_MONTHS'];
                    $sStartDay = $caseSchedulerData['SCH_START_DAY'];
                    $sValue = $nStartDay;
                    break;
            }

            if (($sOption != '1') && ($sOption != '4') && ($sOption != '5')) {
                if ($sStartDay == '') {
                    $sStartDay = date('Y-m-d');
                } else {
                    $size = strlen($caseSchedulerData['SCH_START_DAY']);
                    if ($size > 4) {
                        $aaStartDay = explode( "|", $caseSchedulerData['SCH_START_DAY'] );
                        $aaStartDay[0] = $aaStartDay[0];
                        $aaStartDay[1] = $aaStartDay[1];
                        $aaStartDay[2]= ($aaStartDay[2] == 7 ? 1 : $aaStartDay[2]);
                        $sStartDay = $aaStartDay[0].'|'.$aaStartDay[1].'|'.$aaStartDay[2];
                    }
                }
                $dCurrentDay = date("d");
                $dCurrentMonth = date("m");
                $aStartDay = explode( "|", $caseSchedulerData['SCH_START_DAY'] );
                $sDateTmp = '';
                if ($sOption == '3' && $aStartDay[0] == '1') {
                    $monthsArray = explode( "|", $sMonths );
                    foreach ($monthsArray as $row) {
                        if ($dCurrentMonth == $row && $dCurrentDay < $aStartDay[1]) {
                            $startTime = $caseSchedulerData['SCH_START_TIME'] . ":00";
                            $caseSchedulerData['SCH_TIME_NEXT_RUN'] = date('Y') . '-' . $row . '-' . $aStartDay[1] . ' ' . $startTime;
                            break;
                        } else {
                            $caseSchedulerData['SCH_TIME_NEXT_RUN'] = $oCaseScheduler->updateNextRun( $sOption, $sValue, $nActualTime, $sDaysPerformTask, $sWeeks, $sStartDay, $sMonths, $sDateTmp );
                        }
                    }
                } else {
                    $caseSchedulerData['SCH_TIME_NEXT_RUN'] = $oCaseScheduler->updateNextRun( $sOption, $sValue, $nActualTime, $sDaysPerformTask, $sWeeks, $sStartDay, $sMonths, $sDateTmp );
                }
            } else {
                if ($sOption == '4') {
                    $sDateTmp = date('Y-m-d');
                    $caseSchedulerData['SCH_START_TIME'] = date('Y-m-d', strtotime( $sDateTmp )) . ' ' . date('H:i:s', strtotime( $sTimeTmp ));
                    $caseSchedulerData['SCH_START_DATE'] = $caseSchedulerData['SCH_START_TIME'];
                    $caseSchedulerData['SCH_END_DATE'] = $caseSchedulerData['SCH_START_TIME'];
                }
                $caseSchedulerData['SCH_TIME_NEXT_RUN'] = $caseSchedulerData['SCH_START_TIME'];
                if ($sOption == '5') {
                    if ($caseSchedulerData['SCH_START_DATE'] != '') {
                        $sDateTmp = $caseSchedulerData['SCH_START_DATE'];
                    } else {
                        $sDateTmp = date('Y-m-d');
                        $caseSchedulerData['SCH_START_DATE'] = $sDateTmp;
                    }
                    $caseSchedulerData['SCH_START_TIME'] = time();
                    $caseSchedulerData['SCH_START_DATE'] = $caseSchedulerData['SCH_START_TIME'];
                    if ($caseSchedulerData['SCH_REPEAT_EVERY'] == "") {
                        throw new \Exception(\G::LoadTranslation("ID_CAN_NOT_BE_NULL", array('sch_repeat_every')));
                    }
                    $patternHour="/^([0-9]|0[0-9]|1[0-9]|2[0-3]).[0-5][0-9]$/";
                    if (!preg_match($patternHour, $caseSchedulerData['SCH_REPEAT_EVERY'])) {
                        throw new \Exception(\G::LoadTranslation("ID_INVALID_SCH_REPEAT"));
                    }
                    $nextRun = $caseSchedulerData['SCH_REPEAT_EVERY'] * 60 * 60;
                    $caseSchedulerData['SCH_REPEAT_EVERY'] = $caseSchedulerData['SCH_REPEAT_EVERY'];
                    $date = $caseSchedulerData['SCH_START_TIME'];
                    $date += $nextRun;
                    $date = date("Y-m-d H:i", $date);
                    $caseSchedulerData['SCH_TIME_NEXT_RUN'] = $date;
                }
            }
            if (! empty( $caseSchedulerData['SCH_REPEAT_TASK_CHK'] )) {
                if (trim( $caseSchedulerData['SCH_END_DATE'] ) != '') {
                    $caseSchedulerData['SCH_END_DATE'] = $caseSchedulerData['SCH_END_DATE'];
                }
            }
            if (! empty( $caseSchedulerData['SCH_REPEAT_TASK_CHK'] )) {
                $nOptEvery = $caseSchedulerData['SCH_REPEAT_EVERY_OPT'];
                if ($nOptEvery == 2) {
                    $caseSchedulerData['SCH_REPEAT_EVERY'] = $caseSchedulerData['SCH_REPEAT_EVERY'] * 60;
                } else {
                    $caseSchedulerData['SCH_REPEAT_EVERY'] = $caseSchedulerData['SCH_REPEAT_EVERY'];
                }
            }
            if ((isset( $caseSchedulerData['CASE_SH_PLUGIN_UID'] )) && ($caseSchedulerData['CASE_SH_PLUGIN_UID'] != "")) {
                $caseSchedulerData['CASE_SH_PLUGIN_UID'] = $caseSchedulerData['CASE_SH_PLUGIN_UID'];
            }
            // check this data
            $caseSchedulerData['SCH_REPEAT_UNTIL'] = '';
            $caseSchedulerData['SCH_REPEAT_STOP_IF_RUNNING'] = '0';
            $caseSchedulerData['CASE_SH_PLUGIN_UID'] = null;
            //
            $oCaseScheduler->Update($caseSchedulerData);
            $oCriteria = $this->getCaseScheduler($sProcessUID, $sSchUID);
            return $oCriteria;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Delete a case scheduler of a project
     *
     * @param string $sSchUID
     *
     * @access public
     */
    public function deleteCaseScheduler($sSchUID)
    {
        try {
            require_once(PATH_TRUNK . "workflow" . PATH_SEP . "engine" . PATH_SEP . "classes" . PATH_SEP . "model" . PATH_SEP . "CaseScheduler.php");
            $oCaseScheduler = new \CaseScheduler();
            if (!isset($sSchUID)) {
                return;
            }
            $event = \BpmnEventPeer::retrieveByPK($sSchUID);
            if (is_object($event)) {
                $event->delete();
            }
            $oCaseScheduler->remove($sSchUID);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

