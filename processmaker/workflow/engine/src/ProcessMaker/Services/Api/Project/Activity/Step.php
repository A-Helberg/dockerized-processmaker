<?php
namespace ProcessMaker\Services\Api\Project\Activity;

use \ProcessMaker\Services\Api;
use \Luracast\Restler\RestException;

/**
 * Project\Activity\Step Api Controller
 *
 * @protected
 */
class Step extends Api
{
    /**
     * @url GET /:prj_uid/activity/:act_uid/step/:step_uid
     *
     * @param string $step_uid {@min 32}{@max 32}
     * @param string $act_uid  {@min 32}{@max 32}
     * @param string $prj_uid  {@min 32}{@max 32}
     */
    public function doGetActivityStep($step_uid, $act_uid, $prj_uid)
    {
        try {
            $step = new \ProcessMaker\BusinessModel\Step();
            $step->setFormatFieldNameInUppercase(false);
            $step->setArrayParamException(array("stepUid" => "step_uid", "taskUid" => "act_uid", "processUid" => "prj_uid"));

            $response = $step->getStep($step_uid);

            return $response;
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url POST /:prj_uid/activity/:act_uid/step
     *
     * @param string $act_uid        {@min 32}{@max 32}
     * @param string $prj_uid        {@min 32}{@max 32}
     * @param array  $request_data
     * @param string $step_type_obj  {@from body}{@choice DYNAFORM,INPUT_DOCUMENT,OUTPUT_DOCUMENT,EXTERNAL}{@required true}
     * @param string $step_uid_obj   {@from body}{@min 32}{@max 32}{@required true}
     * @param string $step_condition {@from body}
     * @param int    $step_position  {@from body}{@min 1}
     * @param string $step_mode      {@from body}{@choice EDIT,VIEW}{@required true}
     *
     * @status 201
     */
    public function doPostActivityStep(
        $act_uid,
        $prj_uid,
        $request_data,
        $step_type_obj = "DYNAFORM",
        $step_uid_obj = "00000000000000000000000000000000",
        $step_condition = "",
        $step_position = 1,
        $step_mode = "EDIT"
    ) {
        try {
            $step = new \ProcessMaker\BusinessModel\Step();
            $step->setFormatFieldNameInUppercase(false);
            $step->setArrayParamException(array("stepUid" => "step_uid", "taskUid" => "act_uid", "processUid" => "prj_uid"));

            $arrayData = $step->create($act_uid, $prj_uid, $request_data);

            $response = $arrayData;

            return $response;
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url PUT /:prj_uid/activity/:act_uid/step/:step_uid
     *
     * @param string $step_uid       {@min 32}{@max 32}
     * @param string $act_uid        {@min 32}{@max 32}
     * @param string $prj_uid        {@min 32}{@max 32}
     * @param array  $request_data
     * @param string $step_type_obj  {@from body}{@choice DYNAFORM,INPUT_DOCUMENT,OUTPUT_DOCUMENT,EXTERNAL}
     * @param string $step_uid_obj   {@from body}{@min 32}{@max 32}
     * @param string $step_condition {@from body}
     * @param int    $step_position  {@from body}{@min 1}
     * @param string $step_mode      {@from body}{@choice EDIT,VIEW}
     */
    public function doPutActivityStep(
        $step_uid,
        $act_uid,
        $prj_uid,
        $request_data,
        $step_type_obj = "DYNAFORM",
        $step_uid_obj = "00000000000000000000000000000000",
        $step_condition = "",
        $step_position = 1,
        $step_mode = "EDIT"
    ) {
        try {
            $step = new \ProcessMaker\BusinessModel\Step();
            $step->setFormatFieldNameInUppercase(false);
            $step->setArrayParamException(array("stepUid" => "step_uid", "taskUid" => "act_uid", "processUid" => "prj_uid"));

            $arrayData = $step->update($step_uid, $request_data);
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url DELETE /:prj_uid/activity/:act_uid/step/:step_uid
     *
     * @param string $step_uid {@min 32}{@max 32}
     * @param string $act_uid  {@min 32}{@max 32}
     * @param string $prj_uid  {@min 32}{@max 32}
     */
    public function doDeleteActivityStep($step_uid, $act_uid, $prj_uid)
    {
        try {
            $step = new \ProcessMaker\BusinessModel\Step();
            $step->setFormatFieldNameInUppercase(false);
            $step->setArrayParamException(array("stepUid" => "step_uid", "taskUid" => "act_uid", "processUid" => "prj_uid"));

            $step->delete($step_uid);
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url GET /:prj_uid/activity/:act_uid/step/:step_uid/triggers
     *
     * @param string $step_uid {@min 32}{@max 32}
     * @param string $act_uid  {@min 32}{@max 32}
     * @param string $prj_uid  {@min 32}{@max 32}
     */
    public function doGetActivityStepTriggers($step_uid, $act_uid, $prj_uid)
    {
        try {
            $step = new \ProcessMaker\BusinessModel\Step();
            $step->setFormatFieldNameInUppercase(false);
            $step->setArrayParamException(array("stepUid" => "step_uid", "taskUid" => "act_uid", "processUid" => "prj_uid"));

            $response = $step->getTriggers($step_uid);

            return $response;
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url GET /:prj_uid/activity/:act_uid/step/:step_uid/available-triggers/:type
     *
     * @param string $step_uid {@min 32}{@max 32}
     * @param string $act_uid  {@min 32}{@max 32}
     * @param string $prj_uid  {@min 32}{@max 32}
     * @param string $type     {@choice before,after}
     */
    public function doGetActivityStepAvailableTriggers($step_uid, $act_uid, $prj_uid, $type)
    {
        try {
            $step = new \ProcessMaker\BusinessModel\Step();
            $step->setFormatFieldNameInUppercase(false);
            $step->setArrayParamException(array("stepUid" => "step_uid", "taskUid" => "act_uid", "processUid" => "prj_uid"));

            $response = $step->getAvailableTriggers($step_uid, strtoupper($type));

            return $response;
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    //Step "Assign Task"

    /**
     * @url GET /:prj_uid/activity/:act_uid/step/triggers
     *
     * @param string $act_uid {@min 32}{@max 32}
     * @param string $prj_uid {@min 32}{@max 32}
     */
    public function doGetActivityStepAssignTaskTriggers($act_uid, $prj_uid)
    {
        try {
            $step = new \ProcessMaker\BusinessModel\Step();
            $step->setFormatFieldNameInUppercase(false);
            $step->setArrayParamException(array("stepUid" => "step_uid", "taskUid" => "act_uid", "processUid" => "prj_uid"));

            $response = $step->getTriggers("", $act_uid);

            return $response;
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url GET /:prj_uid/activity/:act_uid/step/available-triggers/:type
     *
     * @param string $act_uid {@min 32}{@max 32}
     * @param string $prj_uid {@min 32}{@max 32}
     * @param string $type    {@choice before-assignment,before-routing,after-routing}
     */
    public function doGetActivityStepAssignTaskAvailableTriggers($act_uid, $prj_uid, $type)
    {
        try {
            $step = new \ProcessMaker\BusinessModel\Step();
            $step->setFormatFieldNameInUppercase(false);
            $step->setArrayParamException(array("stepUid" => "step_uid", "taskUid" => "act_uid", "processUid" => "prj_uid"));

            $response = $step->getAvailableTriggers("", strtoupper(str_replace("-", "_", $type)), $act_uid);

            return $response;
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }
}

