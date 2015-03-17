<?php
$callback = isset($_POST['callback']) ? $_POST['callback'] : 'stcCallback1001';
$dir    = isset($_POST['dir'])    ? $_POST['dir']    : 'DESC';
$sort   = isset($_POST['sort'])   ? $_POST['sort']   : '';
$query  = isset($_POST['query']) ? $_POST['query'] : '';
$option = '';

if ( isset($_GET['t'] ) ) {
    $option = $_GET['t'];
}

try {
    G::LoadClass("BasePeer" );
    require_once ( "classes/model/AdditionalTables.php" );
    require_once ( "classes/model/Fields.php" );

    $sUIDUserLogged = $_SESSION['USER_LOGGED'];
    $oCriteria = new Criteria('workflow');
    $oCriteria->clearSelectColumns ( );
    $oCriteria->setDistinct();
    $oCriteria->addSelectColumn ( AdditionalTablesPeer::ADD_TAB_UID );
    $oCriteria->addSelectColumn ( AdditionalTablesPeer::ADD_TAB_NAME );
    $oCriteria->addSelectColumn ( FieldsPeer::FLD_NAME );
    if ( $query != '' ) {
        $oCriteria->add (AdditionalTablesPeer::ADD_TAB_NAME, $query . '%', Criteria::LIKE);
    }
    $oCriteria->addJoin(AdditionalTablesPeer::ADD_TAB_UID, FieldsPeer::ADD_TAB_UID);
    $oCriteria->add (AdditionalTablesPeer::DBS_UID, 'workflow', CRITERIA::EQUAL );
    $oCriteria->add (FieldsPeer::FLD_NAME, 'APP_UID', CRITERIA::EQUAL );

    if (isset($limit)) {
        $oCriteria->setLimit($limit);
    }

    if (isset($start)) {
        $oCriteria->setOffset($start);
    }

    if ($sort != '') {
        if ($dir == 'DESC') {
            $oCriteria->addDescendingOrderByColumn( $sort );
        } else {
            $oCriteria->addAscendingOrderByColumn( $sort );
        }
    }

    $oDataset = AdditionalTablesPeer::doSelectRS($oCriteria);
    $oDataset->setFetchmode(ResultSet::FETCHMODE_ASSOC);
    $oDataset->next();
    $result = array();
    $rows = array();
    $index =  isset($start) ? $start : 0;

    while ($aRow = $oDataset->getRow()) {
        $aRow['index'] = ++$index;
        $rows[] = $aRow;
        $oDataset->next();
    }
    $result['totalCount'] = count($rows);
    $result['data'] = $rows;
    print G::json_encode( $result );
} catch (Exception $e) {
    print G::json_encode ($e->getMessage());
}

