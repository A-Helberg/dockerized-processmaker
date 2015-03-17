<?php
namespace ProcessMaker\BusinessModel;

use \G;
use \DbSource;
use \dbConnections;

class DataBaseConnection
{
    /**
     * List of DataBaseConnections in process
     * @var string $pro_uid. Uid for Process
     *
     * @author Brayan Pereyra (Cochalo) <brayan@colosa.com>
     * @copyright Colosa - Bolivia
     *
     * @return array
     */
    public function getDataBaseConnections($pro_uid)
    {
        $pro_uid = $this->validateProUid($pro_uid);

        $oDBSource = new DbSource();
        $oCriteria = $oDBSource->getCriteriaDBSList($pro_uid);

        $rs = \DbSourcePeer::doSelectRS($oCriteria);
        $rs->setFetchmode( \ResultSet::FETCHMODE_ASSOC );
        $rs->next();

        $dbConnecions = array();
        while ($row = $rs->getRow()) {
            $row = array_change_key_case($row, CASE_LOWER);
            $dataDb = $this->getDataBaseConnection($pro_uid, $row['dbs_uid'], false);
            $dbConnecions[] = array_change_key_case($dataDb, CASE_LOWER);
            $rs->next();
        }
        return $dbConnecions;
    }

    /**
     * Get data for DataBaseConnection
     * @var string $pro_uid. Uid for Process
     * @var string $dbs_uid. Uid for Data Base Connection
     *
     * @author Brayan Pereyra (Cochalo) <brayan@colosa.com>
     * @copyright Colosa - Bolivia
     *
     * return object
     */
    public function getDataBaseConnection($pro_uid, $dbs_uid, $validate = true)
    {
        try {
            if ($validate) {
                $pro_uid = $this->validateProUid($pro_uid);
                $dbs_uid = $this->validateDbsUid($dbs_uid, $pro_uid);
            }

            G::LoadClass( 'dbConnections' );
            $dbs = new dbConnections($pro_uid);
            $oDBConnection = new DbSource();
            $aFields = $oDBConnection->load($dbs_uid, $pro_uid);
            if ($aFields['DBS_PORT'] == '0') {
                $aFields['DBS_PORT'] = '';
            }
            $aFields['DBS_PASSWORD'] = $dbs->getPassWithoutEncrypt($aFields);

            $response = array_change_key_case($aFields, CASE_LOWER);
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Save Data for DataBaseConnection
     * @var string $pro_uid. Uid for Process
     * @var string $dataDataBaseConnection. Data for DataBaseConnection
     * @var string $create. Create o Update DataBaseConnection
     * @var string $sDataBaseConnectionUid. Uid for DataBaseConnection
     *
     * @author Brayan Pereyra (Cochalo) <brayan@colosa.com>
     * @copyright Colosa - Bolivia
     *
     * @return array
     */
    public function saveDataBaseConnection($pro_uid = '', $dataDBConnection = array(), $create = false)
    {
        $pro_uid = $this->validateProUid($pro_uid);
        if (!$create) {
            $dbs_uid = $dataDBConnection['dbs_uid'];
            $dbs_uid = $this->validateDbsUid($dbs_uid, $pro_uid);
        }

        G::LoadClass('dbConnections');
        $oDBSource = new DbSource();
        $oContent  = new \Content();
        $dataDBConnection = array_change_key_case($dataDBConnection, CASE_UPPER);

        $dataDBConnection['PRO_UID'] = $pro_uid;

        if (isset($dataDBConnection['DBS_TYPE'])) {
            $typesExists = array();
            $dbServices = $this->getDbEngines();
            foreach ($dbServices as $value) {
                $typesExists[] = $value['id'];
            }
            if (!in_array($dataDBConnection['DBS_TYPE'], $typesExists)) {
                throw (new \Exception(\G::LoadTranslation("ID_DBC_TYPE_INVALID", array($dataDBConnection['DBS_TYPE']))));
            }
        }

        if (isset($dataDBConnection['DBS_SERVER']) && $dataDBConnection['DBS_SERVER'] == '') {
            throw (new \Exception(\G::LoadTranslation("ID_DBC_SERVER_INVALID", array($dataDBConnection['DBS_SERVER']))));
        }

        if (isset($dataDBConnection['DBS_DATABASE_NAME']) && $dataDBConnection['DBS_DATABASE_NAME'] == '') {
            throw (new \Exception(\G::LoadTranslation("ID_DBC_DBNAME_INVALID", array($dataDBConnection['DBS_DATABASE_NAME']))));
        }

        if (isset($dataDBConnection['DBS_PORT']) &&
            ($dataDBConnection['DBS_PORT'] == ''|| $dataDBConnection['DBS_PORT'] == 0)) {
            throw (new \Exception(\G::LoadTranslation("ID_DBC_PORT_INVALID", array($dataDBConnection['DBS_PORT']))));
        }

        if (isset($dataDBConnection['DBS_ENCODE'])) {
            $encodesExists = array();
            $dbs = new dbConnections();
            $dbEncodes = $dbs->getEncondeList($dataDBConnection['DBS_TYPE']);
            foreach ($dbEncodes as $value) {
                $encodesExists[] = $value['0'];
            }
            if (!in_array($dataDBConnection['DBS_ENCODE'], $encodesExists)) {
                throw (new \Exception(\G::LoadTranslation("ID_DBC_ENCODE_INVALID", array($dataDBConnection['DBS_ENCODE']))));
            }
        }

        $passOrigin = '';
        if (isset($dataDBConnection['DBS_PASSWORD'])) {
            $passOrigin = $dataDBConnection['DBS_PASSWORD'];
            if ($dataDBConnection['DBS_PASSWORD'] == 'none') {
                $dataDBConnection['DBS_PASSWORD'] = '';
            } else {
                $pass = G::encrypt( $dataDBConnection['DBS_PASSWORD'], $dataDBConnection['DBS_DATABASE_NAME']) . "_2NnV3ujj3w";
                $dataDBConnection['DBS_PASSWORD'] = $pass;
            }
        }

        if ($create) {
            unset($dataDBConnection['DBS_UID']);
            // TEST CONNECTION
            $dataTest = array_merge($dataDBConnection, array('DBS_PASSWORD' => $passOrigin));
            $resTest = $this->testConnection($dataTest);
            if (!$resTest['resp']) {
                throw (new \Exception($resTest['message']));
            }
            $newDBConnectionUid = $oDBSource->create($dataDBConnection);
            $oContent->addContent('DBS_DESCRIPTION', '', $newDBConnectionUid,
                SYS_LANG, $dataDBConnection['DBS_DESCRIPTION'] );
            $newDataDBConnection = $this->getDataBaseConnection($pro_uid, $newDBConnectionUid);
            $newDataDBConnection = array_change_key_case($newDataDBConnection, CASE_LOWER);
            return $newDataDBConnection;
        } else {
            // TEST CONNECTION
            $allData = $this->getDataBaseConnection($pro_uid, $dataDBConnection['DBS_UID']);
            $dataTest = array_merge($allData, $dataDBConnection, array('DBS_PASSWORD' => $passOrigin));
            $resTest = $this->testConnection($dataTest);
            if (!$resTest['resp']) {
                throw (new \Exception($resTest['message']));
            }
            $oDBSource->update($dataDBConnection);
            if (isset($dataDBConnection['DBS_DESCRIPTION'])) {
                $oContent->addContent('DBS_DESCRIPTION', '', $dataDBConnection['DBS_UID'],
                    SYS_LANG, $dataDBConnection['DBS_DESCRIPTION'] );
            }
        }
        return array();
    }

    /**
     * Delete DataBaseConnection
     * @var string $pro_uid. Uid for Process
     * @var string $dbs_uid. Uid for DataBase Connection
     *
     * @author Brayan Pereyra (Cochalo) <brayan@colosa.com>
     * @copyright Colosa - Bolivia
     *
     * @return void
     */
    public function deleteDataBaseConnection($pro_uid, $dbs_uid)
    {
        $pro_uid = $this->validateProUid($pro_uid);
        $dbs_uid = $this->validateDbsUid($dbs_uid, $pro_uid);

        $oDBSource = new DbSource();
        $oContent  = new \Content();

        $oDBSource->remove($dbs_uid, $pro_uid);
        $oContent->removeContent( 'DBS_DESCRIPTION', "", $dbs_uid );
    }

    /**
     * Test DataBase Connection
     * @var string $dataCon. Data for DataBase Connection
     * @var string $returnArray. Flag for url
     *
     * @author Brayan Pereyra (Cochalo) <brayan@colosa.com>
     * @copyright Colosa - Bolivia
     *
     * @return void
     */
    public function testConnection($dataCon, $returnArray = false)
    {
        $resp = array();
        $respTest = array();
        $resp['resp'] = false;

        $dataCon = array_change_key_case($dataCon, CASE_UPPER);

        G::LoadClass( 'net' );
        $Server = new \NET($dataCon['DBS_SERVER']);

        // STEP 1 : Resolving Host Name
        $respTest['0'] = array();
        $respTest['0']['test'] = 'Resolving Host Name ' . $dataCon['DBS_SERVER'];
        if ($Server->getErrno() != 0) {
            if ($returnArray) {
                $respTest['0']['error'] = "Error Testing Connection: Resolving Host Name FAILED : " . $Server->error;
            } else {
                $resp['message'] = "Error Testing Connection: Resolving Host Name FAILED : " . $Server->error;
                return $resp;
            }
        }

        // STEP 2 : Checking port
        $respTest['1'] = array();
        $respTest['1']['test'] = 'Checking port ' . $dataCon['DBS_PORT'];
        $Server->scannPort($dataCon['DBS_PORT']);
        if ($Server->getErrno() != 0) {
            if ($returnArray) {
                $respTest['1']['error'] = "Error Testing Connection: Checking port FAILED : " . $Server->error;
            } else {
                $resp['message'] = "Error Testing Connection: Checking port FAILED : " . $Server->error;
                return $resp;
            }
        }

        // STEP 3 : Trying to connect to host
        $respTest['2'] = array();
        $respTest['2']['test'] = 'Trying to connect to host ' . $dataCon['DBS_SERVER'] . (($dataCon['DBS_PORT'] != '') ? ':'.$dataCon['DBS_PORT'] : '');
        $Server->loginDbServer($dataCon['DBS_USERNAME'], $dataCon['DBS_PASSWORD']);
        $Server->setDataBase($dataCon['DBS_DATABASE_NAME'], $dataCon['DBS_PORT']);
        if ($Server->errno == 0) {
            $response = $Server->tryConnectServer($dataCon['DBS_TYPE']);
            if ($response->status != 'SUCCESS') {
                if ($returnArray) {
                    $respTest['2']['error'] = "Error Testing Connection: Trying to connect to host FAILED : " . $Server->error;
                } else {
                    $resp['message'] = "Error Testing Connection: Trying to connect to host FAILED : " . $Server->error;
                    return $resp;
                }
            }
        } else {
            if ($returnArray) {
                $respTest['2']['error'] = "Error Testing Connection: Trying to connect to host FAILED : " . $Server->error;
            } else {
                $resp['message'] = "Error Testing Connection: Trying to connect to host FAILED : " . $Server->error;
                return $resp;
            }
        }

        // STEP 4 : Trying to open database
        $respTest['3'] = array();
        $respTest['3']['test'] = 'Trying to open database [' . $dataCon['DBS_DATABASE_NAME'] . ']';
        $Server->loginDbServer($dataCon['DBS_USERNAME'], $dataCon['DBS_PASSWORD']);
        $Server->setDataBase($dataCon['DBS_DATABASE_NAME'], $dataCon['DBS_PORT']);
        if ($Server->errno == 0) {
            $response = $Server->tryConnectServer($dataCon['DBS_TYPE']);
            if ($response->status == 'SUCCESS') {
                $response = $Server->tryOpenDataBase($dataCon['DBS_TYPE']);
                if ($response->status != 'SUCCESS') {
                    if ($returnArray) {
                        $respTest['3']['error'] = "Error Testing Connection: Trying to open database FAILED : " . $Server->error;
                    } else {
                        $resp['message'] = "Error Testing Connection: Trying to open database FAILED : " . $Server->error;
                        return $resp;
                    }
                }
            } else {
                if ($returnArray) {
                    $respTest['3']['error'] = "Error Testing Connection: Trying to open database FAILED : " . $Server->error;
                } else {
                    $resp['message'] = "Error Testing Connection: Trying to open database FAILED : " . $Server->error;
                    return $resp;
                }
            }
        } else {
            if ($returnArray) {
                $respTest['3']['error'] = "Error Testing Connection: Trying to open database FAILED : " . $Server->error;
            } else {
                $resp['message'] = "Error Testing Connection: Trying to open database FAILED : " . $Server->error;
                return $resp;
            }
        }

        if ($returnArray) {
            return $respTest;
        } else {
            // CORRECT CONNECTION
            $resp['resp'] = true;
            return $resp;
        }
    }

    /**
     * Get Data Base Engines
     *
     * @author Brayan Pereyra (Cochalo) <brayan@colosa.com>
     * @copyright Colosa - Bolivia
     *
     * @return array
     */
    public function getDbEngines ()
    {
        if (!class_exists('dbConnections')) {
            G::LoadClass('dbConnections');
        }
        $dbs = new dbConnections();
        $dbServices = $dbs->getDbServicesAvailables();
        return $dbServices;
    }

    /**
     * Validate Process Uid
     * @var string $pro_uid. Uid for process
     *
     * @author Brayan Pereyra (Cochalo) <brayan@colosa.com>
     * @copyright Colosa - Bolivia
     *
     * @return string
     */
    public function validateProUid ($pro_uid)
    {
        $pro_uid = trim($pro_uid);
        if ($pro_uid == '') {
            throw (new \Exception(\G::LoadTranslation("ID_PROJECT_NOT_EXIST", array('prj_uid',''))));
        }
        $oProcess = new \Process();
        if (!($oProcess->processExists($pro_uid))) {
            throw (new \Exception(\G::LoadTranslation("ID_PROJECT_NOT_EXIST", array('prj_uid', $pro_uid))));
        }
        return $pro_uid;
    }

    /**
     * Validate DataBase Connection Uid
     * @var string $pro_uid. Uid for process
     * @var string $dbs_uid. Uid for process
     *
     * @author Brayan Pereyra (Cochalo) <brayan@colosa.com>
     * @copyright Colosa - Bolivia
     *
     * @return string
     */
    public function validateDbsUid ($dbs_uid, $pro_uid)
    {
        $dbs_uid = trim($dbs_uid);
        if ($dbs_uid == '') {
            throw (new \Exception(\G::LoadTranslation("ID_DBC_NOT_EXIST", array('dbs_uid',''))));
        }
        $oDBSource = new DbSource();
        if (!($oDBSource->Exists($dbs_uid, $pro_uid))) {
            throw (new \Exception(\G::LoadTranslation("ID_DBC_NOT_EXIST", array('dbs_uid',$dbs_uid))));
        }
        return $dbs_uid;
    }
}

