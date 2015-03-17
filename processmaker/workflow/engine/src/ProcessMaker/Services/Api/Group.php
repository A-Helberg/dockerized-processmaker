<?php
namespace ProcessMaker\Services\Api;

use \ProcessMaker\Services\Api;
use \Luracast\Restler\RestException;

/**
 * Group Api Controller
 *
 * @protected
 */
class Group extends Api
{
    /**
     * @url GET
     */
    public function index($filter = null, $start = null, $limit = null)
    {
        try {
            $group = new \ProcessMaker\BusinessModel\Group();
            $group->setFormatFieldNameInUppercase(false);

            $response = $group->getGroups(array("filter" => $filter), null, null, $start, $limit);

            return $response;
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url GET /:grp_uid
     *
     * @param string $grp_uid {@min 32}{@max 32}
     */
    public function doGet($grp_uid)
    {
        try {
            $group = new \ProcessMaker\BusinessModel\Group();
            $group->setFormatFieldNameInUppercase(false);

            $response = $group->getGroup($grp_uid);

            return $response;
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url POST
     *
     * @param array $request_data
     *
     * @status 201
     */
    public function doPost($request_data)
    {
        try {
            $group = new \ProcessMaker\BusinessModel\Group();
            $group->setFormatFieldNameInUppercase(false);

            $arrayData = $group->create($request_data);

            $response = $arrayData;

            return $response;
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url PUT /:grp_uid
     *
     * @param string $grp_uid      {@min 32}{@max 32}
     * @param array  $request_data
     */
    public function doPut($grp_uid, $request_data)
    {
        try {
            $group = new \ProcessMaker\BusinessModel\Group();
            $group->setFormatFieldNameInUppercase(false);

            $arrayData = $group->update($grp_uid, $request_data);
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url DELETE /:grp_uid
     *
     * @param string $grp_uid {@min 32}{@max 32}
     */
    public function doDelete($grp_uid)
    {
        try {
            $group = new \ProcessMaker\BusinessModel\Group();
            $group->setFormatFieldNameInUppercase(false);

            $group->delete($grp_uid);
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url GET /:grp_uid/users
     *
     * @param string $grp_uid {@min 32}{@max 32}
     */
    public function doGetUsers($grp_uid, $filter = null, $start = null, $limit = null)
    {
        try {
            $group = new \ProcessMaker\BusinessModel\Group();
            $group->setFormatFieldNameInUppercase(false);

            $response = $group->getUsers("USERS", $grp_uid, array("filter" => $filter), null, null, $start, $limit);

            return $response;
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }

    /**
     * @url GET /:grp_uid/available-users
     *
     * @param string $grp_uid {@min 32}{@max 32}
     */
    public function doGetAvailableUsers($grp_uid, $filter = null, $start = null, $limit = null)
    {
        try {
            $group = new \ProcessMaker\BusinessModel\Group();
            $group->setFormatFieldNameInUppercase(false);

            $response = $group->getUsers("AVAILABLE-USERS", $grp_uid, array("filter" => $filter), null, null, $start, $limit);

            return $response;
        } catch (\Exception $e) {
            throw (new RestException(Api::STAT_APP_EXCEPTION, $e->getMessage()));
        }
    }
}

