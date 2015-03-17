<?php
if (!isset($_SESSION['USER_LOGGED'])) {
    $responseObject = new stdclass();
    $responseObject->error = G::LoadTranslation('ID_LOGIN_AGAIN');
    $responseObject->success = true;
    $responseObject->lostSession = true;
    print G::json_encode( $responseObject );
    die();
}

//Getting the extJs parameters
$callback = isset( $_POST["callback"] ) ? $_POST["callback"] : "stcCallback1001";
$dir = isset( $_POST["dir"] ) ? $_POST["dir"] : "DESC";
$sort = isset( $_POST["sort"] ) ? $_POST["sort"] : "";
$start = isset( $_POST["start"] ) ? $_POST["start"] : "0";
$limit = isset( $_POST["limit"] ) ? $_POST["limit"] : "25";
$filter = isset( $_POST["filter"] ) ? $_POST["filter"] : "";
$process = isset( $_POST["process"] ) ? $_POST["process"] : "";
$category = isset( $_POST["category"] ) ? $_POST["category"] : "";
$status = isset( $_POST["status"] ) ? strtoupper( $_POST["status"] ) : "";
$user = isset( $_POST["user"] ) ? $_POST["user"] : "";
$search = isset( $_POST["search"] ) ? $_POST["search"] : "";
$action = isset( $_GET["action"] ) ? $_GET["action"] : (isset( $_POST["action"] ) ? $_POST["action"] : "todo");
$type = isset( $_GET["type"] ) ? $_GET["type"] : (isset( $_POST["type"] ) ? $_POST["type"] : "extjs");
$dateFrom = isset( $_POST["dateFrom"] ) ? substr( $_POST["dateFrom"], 0, 10 ) : "";
$dateTo = isset( $_POST["dateTo"] ) ? substr( $_POST["dateTo"], 0, 10 ) : "";
$first = isset( $_POST["first"] ) ? true :false;

if ($sort == 'CASE_SUMMARY' || $sort == 'CASE_NOTES_COUNT') {
    $sort = 'APP_NUMBER';//DEFAULT VALUE
}
if ($sort == 'APP_STATUS_LABEL') {
    $sort = 'APP_STATUS';
}

try {
    $userUid = (isset($_SESSION["USER_LOGGED"]) && $_SESSION["USER_LOGGED"] != "")? $_SESSION["USER_LOGGED"] : null;
    $result = "";
    $solrEnabled = false;

    switch ($action) {
        case "search":
        case "to_reassign":
            if ($first) {
                $result['totalCount'] = 0;
                $result['data'] = array();
                $result = G::json_encode($result);
                echo $result;
                return ;
            }
            $user = ($user == "CURRENT_USER")? $userUid : $user;
            $userUid = $user;
            break;
        default:
            break;
    }

    if ((
        $action == "todo" || $action == "draft" || $action == "paused" || $action == "sent" ||
        $action == "selfservice" || $action == "unassigned" || $action == "search"
        ) &&
        (($solrConf = System::solrEnv()) !== false)
    ) {
        G::LoadClass("AppSolr");

        $ApplicationSolrIndex = new AppSolr(
            $solrConf["solr_enabled"],
            $solrConf["solr_host"],
            $solrConf["solr_instance"]
        );

        if ($ApplicationSolrIndex->isSolrEnabled() && $solrConf['solr_enabled'] == true) {
            //Check if there are missing records to reindex and reindex them
            $ApplicationSolrIndex->synchronizePendingApplications();
            $solrEnabled = true;
        } else{
            $solrEnabled = false;
        }
    }

    if ($solrEnabled) {
        $data = $ApplicationSolrIndex->getAppGridData(
            $userUid,
            $start,
            $limit,
            $action,
            $filter,
            $search,
            $process,
            $status,
            $type,
            $dateFrom,
            $dateTo,
            $callback,
            $dir,
            $sort,
            $category
        );

        $result = G::json_encode($data);
    } else {
        G::LoadClass("applications");

        $apps = new Applications();
        $data = $apps->getAll(
            $userUid,
            $start,
            $limit,
            $action,
            $filter,
            $search,
            $process,
            $status,
            $type,
            $dateFrom,
            $dateTo,
            $callback,
            $dir,
            (strpos($sort, ".") !== false)? $sort : "APP_CACHE_VIEW." . $sort,
            $category
        );

        $result = G::json_encode($data);
    }

    echo $result;
} catch (Exception $e) {
    $msg = array("error" => $e->getMessage());
    echo G::json_encode($msg);
}

