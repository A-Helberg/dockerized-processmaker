<?php
/**
 * cases_SaveData.php
 *
 * ProcessMaker Open Source Edition
 * Copyright (C) 2004 - 2008 Colosa Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * For more information, contact Colosa Inc, 2566 Le Jeune Rd.,
 * Coral Gables, FL, 33134, USA, or email info@colosa.com.
 */
//validate the data post
if (!isset($_SESSION['USER_LOGGED'])) {
    G::SendTemporalMessage( 'ID_LOGIN_AGAIN', 'warning', 'labels' );
    die( '<script type="text/javascript">
                    try
                      {
                        prnt = parent.parent;
                        top.location = top.location;
                      }
                    catch (err)
                      {
                        parent.location = parent.location;
                      }
                    </script>');
}
try {
    if ($_GET['APP_UID'] !== $_SESSION['APPLICATION']) {
        throw new Exception( G::LoadTranslation( 'ID_INVALID_APPLICATION_ID_MSG', array ('<a href=\'' . $_SERVER['HTTP_REFERER'] . '\'>{1}</a>',G::LoadTranslation( 'ID_REOPEN' ) ) ) );
    }

    /*
     * PMDynaform
     * DYN_VERSION is 1: classic Dynaform,
     * DYN_VERSION is 2: responsive form, Pmdynaform.
     */
    $a = new Criteria("workflow");
    $a->addSelectColumn(DynaformPeer::DYN_VERSION);
    $a->add(DynaformPeer::DYN_UID, $_GET['UID'], Criteria::EQUAL);
    $a = ProcessPeer::doSelectRS($a);
    $a->setFetchmode(ResultSet::FETCHMODE_ASSOC);
    $a->next();
    $row = $a->getRow();
    $swpmdynaform = isset($row) && $row["DYN_VERSION"] == 2;
    if ($swpmdynaform) {
        $pmdynaform = $_POST["form"];
    }

    $oForm = new Form( $_SESSION["PROCESS"] . "/" . $_GET["UID"], PATH_DYNAFORM );
    $oForm->validatePost();

    //Includes
    G::LoadClass( "case" );

    //Load the variables
    $oCase = new Cases();
    $oCase->thisIsTheCurrentUser( $_SESSION["APPLICATION"], $_SESSION["INDEX"], $_SESSION["USER_LOGGED"], "REDIRECT", "casesListExtJs" );
    $Fields = $oCase->loadCase( $_SESSION["APPLICATION"] );

    $Fields["APP_DATA"] = array_merge( $Fields["APP_DATA"], G::getSystemConstants() );
    $Fields["APP_DATA"] = array_merge( $Fields["APP_DATA"], $_POST["form"] );

    #here we must verify if is a debug session
    $trigger_debug_session = isset($_SESSION['TRIGGER_DEBUG']['ISSET']) ? $_SESSION['TRIGGER_DEBUG']['ISSET'] : null; #here we must verify if is a debugg session

    #trigger debug routines...

    //cleaning debug variables
    $_SESSION['TRIGGER_DEBUG']['ERRORS'] = Array ();
    $_SESSION['TRIGGER_DEBUG']['DATA'] = Array ();
    $_SESSION['TRIGGER_DEBUG']['TRIGGERS_NAMES'] = Array ();
    $_SESSION['TRIGGER_DEBUG']['TRIGGERS_VALUES'] = Array ();

    $triggers = $oCase->loadTriggers( $_SESSION['TASK'], 'DYNAFORM', $_GET['UID'], 'AFTER' );

    $_SESSION['TRIGGER_DEBUG']['NUM_TRIGGERS'] = count( $triggers );
    $_SESSION['TRIGGER_DEBUG']['TIME'] = G::toUpper(G::loadTranslation('ID_AFTER'));
    if ($_SESSION['TRIGGER_DEBUG']['NUM_TRIGGERS'] != 0) {
        $_SESSION['TRIGGER_DEBUG']['TRIGGERS_NAMES'] = $oCase->getTriggerNames( $triggers );
        $_SESSION['TRIGGER_DEBUG']['TRIGGERS_VALUES'] = $triggers;
        $oProcess = new Process();
        $oProcessFieds = $oProcess->Load( $_SESSION['PROCESS'] );

        //trigger debug routines...
        if (isset( $oProcessFieds['PRO_DEBUG'] ) && $oProcessFieds['PRO_DEBUG']) {
            $trigger_debug_session = true;
        }
    }

    if ($_SESSION['TRIGGER_DEBUG']['NUM_TRIGGERS'] != 0) {
        //Execute after triggers - Start
        $Fields['APP_DATA'] = $oCase->ExecuteTriggers( $_SESSION['TASK'], 'DYNAFORM', $_GET['UID'], 'AFTER', $Fields['APP_DATA'] );
        //Execute after triggers - End
    }

    //save data in PM Tables if necessary
    $newValues = array ();
    foreach ($_POST['form'] as $sField => $sAux) {
        if (isset( $oForm->fields[$sField]->pmconnection ) && isset( $oForm->fields[$sField]->pmfield )) {
            if (($oForm->fields[$sField]->pmconnection != '') && ($oForm->fields[$sField]->pmfield != '')) {
                if (isset( $oForm->fields[$oForm->fields[$sField]->pmconnection] )) {
                    require_once PATH_CORE . 'classes' . PATH_SEP . 'model' . PATH_SEP . 'AdditionalTables.php';
                    $oAdditionalTables = new AdditionalTables();
                    try {
                        $aData = $oAdditionalTables->load( $oForm->fields[$oForm->fields[$sField]->pmconnection]->pmtable, true );
                    } catch (Exception $oError) {
                        $aData = array ('FIELDS' => array ()
                        );
                    }
                    $aKeys = array ();
                    $aAux = explode( '|', $oForm->fields[$oForm->fields[$sField]->pmconnection]->keys );
                    $i = 0;
                    $aValues = array ();
                    foreach ($aData['FIELDS'] as $aField) {
                        if ($aField['FLD_KEY'] == '1') {
                            $aKeys[$aField['FLD_NAME']] = (isset( $aAux[$i] ) ? G::replaceDataField( $aAux[$i], $Fields['APP_DATA'] ) : '');
                            $i ++;
                        }
                        if ($aField['FLD_NAME'] == $oForm->fields[$sField]->pmfield) {
                            $aValues[$aField['FLD_NAME']] = $Fields['APP_DATA'][$sField];
                        } else {
                            $aValues[$aField['FLD_NAME']] = '';
                        }
                    }
                    try {
                        $aRow = $oAdditionalTables->getDataTable( $oForm->fields[$oForm->fields[$sField]->pmconnection]->pmtable, $aKeys );
                    } catch (Exception $oError) {
                        $aRow = false;
                    }
                    if ($aRow) {
                        foreach ($aValues as $sKey => $sValue) {
                            if ($sKey != $oForm->fields[$sField]->pmfield) {
                                $aValues[$sKey] = $aRow[$sKey];
                            }
                        }
                        try {
                            $oAdditionalTables->updateDataInTable( $oForm->fields[$oForm->fields[$sField]->pmconnection]->pmtable, $aValues );
                        } catch (Exception $oError) {
                            //Nothing
                        }
                    } else {
                        try {
                            // assembling the field list in order to save the data ina new record of a pm table
                            if (empty( $newValues )) {
                                $newValues = $aValues;
                            } else {
                                foreach ($aValues as $aValueKey => $aValueCont) {
                                    if (trim( $newValues[$aValueKey] ) == '') {
                                        $newValues[$aValueKey] = $aValueCont;
                                    }
                                }
                            }
                            //$oAdditionalTables->saveDataInTable ( $oForm->fields [$oForm->fields [$sField]->pmconnection]->pmtable, $aValues );
                        } catch (Exception $oError) {
                            //Nothing
                        }
                    }
                }
            }
        }
    }

    //save data
    $aData = array ();
    $aData['APP_NUMBER'] = $Fields['APP_NUMBER'];
    //$aData['APP_PROC_STATUS'] = $Fields['APP_PROC_STATUS'];
    $aData['APP_DATA'] = $Fields['APP_DATA'];
    $aData['DEL_INDEX'] = $_SESSION['INDEX'];
    $aData['TAS_UID'] = $_SESSION['TASK'];
    $aData['CURRENT_DYNAFORM'] = $_GET['UID'];
    $aData['USER_UID'] = $_SESSION['USER_LOGGED'];
    //$aData['APP_STATUS'] = $Fields['APP_STATUS'];
    $aData['PRO_UID'] = $_SESSION['PROCESS'];

    if ($swpmdynaform) {
        $aData['APP_DATA'] = array_merge($aData['APP_DATA'], $pmdynaform);
        $_POST["DynaformRequiredFields"] = '[]';
    }

    $oCase->updateCase( $_SESSION['APPLICATION'], $aData );

    // saving the data ina pm table in case that is a new record
    if (! empty( $newValues )) {

        $id = key( $newValues );
        $newValues[$id] = $aData['APP_DATA'][$id];
        foreach ($aKeys as $key => $value) {
            if (!isset($newValues[$key]) || $newValues[$key] == '') {
                $G_PUBLISH = new Publisher();
                $aMessage = array ();
                $aMessage['MESSAGE'] = G::LoadTranslation('ID_FILL_PRIMARY_KEYS') . ' ('. $key . ') ';
                $G_PUBLISH->AddContent( 'xmlform', 'xmlform', 'login/showMessage', '', $aMessage );
                G::RenderPage( 'publish', 'blank' );
                die();
            }
        }
        
        $idPmtable = isset($oForm->fields[$id]->pmconnection->pmtable) && $oForm->fields[$id]->pmconnection->pmtable != '' ? $oForm->fields[$id]->pmconnection->pmtable : $oForm->fields[$id]->owner->tree->children[0]->attributes['pmtable'];
        
        if (!($oAdditionalTables->updateDataInTable($idPmtable, $newValues ))) {
            //<--This is to know if it is a new registry on the PM Table
            $oAdditionalTables->saveDataInTable($idPmtable, $newValues );
        }
    }

    //Save files
    //require_once ("classes/model/AppDocument.php");

    if (isset( $_FILES["form"]["name"] ) && count( $_FILES["form"]["name"] ) > 0) {
        $arrayField = array ();
        $arrayFileName = array ();
        $arrayFileTmpName = array ();
        $arrayFileError = array ();
        $i = 0;

        foreach ($_FILES["form"]["name"] as $fieldIndex => $fieldValue) {
            if (is_array( $fieldValue )) {
                foreach ($fieldValue as $index => $value) {
                    if (is_array( $value )) {
                        foreach ($value as $grdFieldIndex => $grdFieldValue) {
                            $arrayField[$i]["grdName"] = $fieldIndex;
                            $arrayField[$i]["grdFieldName"] = $grdFieldIndex;
                            $arrayField[$i]["index"] = $index;

                            $arrayFileName[$i] = $_FILES["form"]["name"][$fieldIndex][$index][$grdFieldIndex];
                            $arrayFileTmpName[$i] = $_FILES["form"]["tmp_name"][$fieldIndex][$index][$grdFieldIndex];
                            $arrayFileError[$i] = $_FILES["form"]["error"][$fieldIndex][$index][$grdFieldIndex];
                            $i = $i + 1;
                        }
                    }
                }
            } else {
                $arrayField[$i] = $fieldIndex;

                $arrayFileName[$i] = $_FILES["form"]["name"][$fieldIndex];
                $arrayFileTmpName[$i] = $_FILES["form"]["tmp_name"][$fieldIndex];
                $arrayFileError[$i] = $_FILES["form"]["error"][$fieldIndex];
                $i = $i + 1;
            }
        }
        if (count( $arrayField ) > 0) {
            for ($i = 0; $i <= count( $arrayField ) - 1; $i ++) {
                if ($arrayFileError[$i] == 0) {
                    $indocUid = null;
                    $fieldName = null;
                    $fileSizeByField = 0;

                    if (is_array( $arrayField[$i] )) {
                        if (isset( $_POST["INPUTS"][$arrayField[$i]["grdName"]][$arrayField[$i]["grdFieldName"]] ) && ! empty( $_POST["INPUTS"][$arrayField[$i]["grdName"]][$arrayField[$i]["grdFieldName"]] )) {
                            $indocUid = $_POST["INPUTS"][$arrayField[$i]["grdName"]][$arrayField[$i]["grdFieldName"]];
                        }

                        $fieldName = $arrayField[$i]["grdName"] . "_" . $arrayField[$i]["index"] . "_" . $arrayField[$i]["grdFieldName"];

                        if (isset($_FILES["form"]["size"][$arrayField[$i]["grdName"]][$arrayField[$i]["index"]][$arrayField[$i]["grdFieldName"]])) {
                            $fileSizeByField = $_FILES["form"]["size"][$arrayField[$i]["grdName"]][$arrayField[$i]["index"]][$arrayField[$i]["grdFieldName"]];
                        }
                    } else {
                        if (isset( $_POST["INPUTS"][$arrayField[$i]] ) && ! empty( $_POST["INPUTS"][$arrayField[$i]] )) {
                            $indocUid = $_POST["INPUTS"][$arrayField[$i]];
                        }

                        $fieldName = $arrayField[$i];

                        if (isset($_FILES["form"]["size"][$fieldName])) {
                            $fileSizeByField = $_FILES["form"]["size"][$fieldName];
                        }
                    }

                    if ($indocUid != null) {
                        //require_once ("classes/model/AppFolder.php");
                        //require_once ("classes/model/InputDocument.php");

                        $oInputDocument = new InputDocument();
                        $aID = $oInputDocument->load( $indocUid );

                        //Get the Custom Folder ID (create if necessary)
                        $oFolder = new AppFolder();

						//***Validating the file allowed extensions***
						$res = G::verifyInputDocExtension($aID['INP_DOC_TYPE_FILE'], $arrayFileName[$i], $arrayFileTmpName[$i]);
						if($res->status == 0){
							$message = $res->message;
							G::SendMessageText( $message, "ERROR" );
							$backUrlObj = explode( "sys" . SYS_SYS, $_SERVER['HTTP_REFERER'] );
							G::header( "location: " . "/sys" . SYS_SYS . $backUrlObj[1] );
							die();
						}

                        //--- Validate Filesize of $_FILE
                        $inpDocMaxFilesize = $aID["INP_DOC_MAX_FILESIZE"];
                        $inpDocMaxFilesizeUnit = $aID["INP_DOC_MAX_FILESIZE_UNIT"];

                        $inpDocMaxFilesize = $inpDocMaxFilesize * (($inpDocMaxFilesizeUnit == "MB")? 1024 *1024 : 1024); //Bytes

                        if ($inpDocMaxFilesize > 0 && $fileSizeByField > 0) {
                            if ($fileSizeByField > $inpDocMaxFilesize) {
                                G::SendMessageText(G::LoadTranslation("ID_SIZE_VERY_LARGE_PERMITTED"), "ERROR");
                                $arrayAux1 = explode("sys" . SYS_SYS, $_SERVER["HTTP_REFERER"]);
                                G::header("location: /sys" . SYS_SYS . $arrayAux1[1]);
                                exit(0);
                            }
                        }

                        $aFields = array ("APP_UID" => $_SESSION["APPLICATION"],"DEL_INDEX" => $_SESSION["INDEX"],"USR_UID" => $_SESSION["USER_LOGGED"],"DOC_UID" => $indocUid,"APP_DOC_TYPE" => "INPUT","APP_DOC_CREATE_DATE" => date( "Y-m-d H:i:s" ),"APP_DOC_COMMENT" => "","APP_DOC_TITLE" => "","APP_DOC_FILENAME" => $arrayFileName[$i],"FOLDER_UID" => $oFolder->createFromPath( $aID["INP_DOC_DESTINATION_PATH"] ),"APP_DOC_TAGS" => $oFolder->parseTags( $aID["INP_DOC_TAGS"] ),"APP_DOC_FIELDNAME" => $fieldName);
                    } else {
                        $aFields = array ("APP_UID" => $_SESSION["APPLICATION"],"DEL_INDEX" => $_SESSION["INDEX"],"USR_UID" => $_SESSION["USER_LOGGED"],"DOC_UID" => - 1,"APP_DOC_TYPE" => "ATTACHED","APP_DOC_CREATE_DATE" => date( "Y-m-d H:i:s" ),"APP_DOC_COMMENT" => "","APP_DOC_TITLE" => "","APP_DOC_FILENAME" => $arrayFileName[$i],"APP_DOC_FIELDNAME" => $fieldName);
                    }

                    $oAppDocument = new AppDocument();
                    $oAppDocument->create( $aFields );

                    $iDocVersion = $oAppDocument->getDocVersion();
                    $sAppDocUid = $oAppDocument->getAppDocUid();
                    $aInfo = pathinfo( $oAppDocument->getAppDocFilename() );
                    $sExtension = ((isset( $aInfo["extension"] )) ? $aInfo["extension"] : "");
                    $pathUID = G::getPathFromUID($_SESSION["APPLICATION"]);
                    $sPathName = PATH_DOCUMENT . $pathUID . PATH_SEP;
                    $sFileName = $sAppDocUid . "_" . $iDocVersion . "." . $sExtension;
                    G::uploadFile( $arrayFileTmpName[$i], $sPathName, $sFileName );

                    //Plugin Hook PM_UPLOAD_DOCUMENT for upload document
                    $oPluginRegistry = &PMPluginRegistry::getSingleton();

                    if ($oPluginRegistry->existsTrigger( PM_UPLOAD_DOCUMENT ) && class_exists( "uploadDocumentData" )) {
                        $triggerDetail = $oPluginRegistry->getTriggerInfo( PM_UPLOAD_DOCUMENT );
                        $documentData = new uploadDocumentData( $_SESSION["APPLICATION"], $_SESSION["USER_LOGGED"], $sPathName . $sFileName, $aFields["APP_DOC_FILENAME"], $sAppDocUid, $iDocVersion );
                        $uploadReturn = $oPluginRegistry->executeTriggers( PM_UPLOAD_DOCUMENT, $documentData );

                        if ($uploadReturn) {
                            $aFields["APP_DOC_PLUGIN"] = $triggerDetail->sNamespace;

                            if (! isset( $aFields["APP_DOC_UID"] )) {
                                $aFields["APP_DOC_UID"] = $sAppDocUid;
                            }

                            if (! isset( $aFields["DOC_VERSION"] )) {
                                $aFields["DOC_VERSION"] = $iDocVersion;
                            }

                            $oAppDocument->update( $aFields );

                            unlink( $sPathName . $sFileName );
                        }
                    }
                }
            }
        }
    }

    //Go to the next step
    $aNextStep = $oCase->getNextStep( $_SESSION['PROCESS'], $_SESSION['APPLICATION'], $_SESSION['INDEX'], $_SESSION['STEP_POSITION'] );
    if (isset( $_GET['_REFRESH_'] )) {
        G::header( 'location: ' . $_SERVER['HTTP_REFERER'] );
        die();
    }

    $_SESSION['STEP_POSITION'] = $aNextStep['POSITION'];
    $_SESSION['BREAKSTEP']['NEXT_STEP'] = $aNextStep['PAGE'];
    $debuggerAvailable = true;

    if (isset( $_SESSION['current_ux'] ) && $_SESSION['current_ux'] == 'SIMPLIFIED') {
        $debuggerAvailable = false;
    }

    if ($trigger_debug_session && $debuggerAvailable) {
        $_SESSION['TRIGGER_DEBUG']['BREAKPAGE'] = $aNextStep['PAGE'];
        $aNextStep['PAGE'] = $aNextStep['PAGE'] . '&breakpoint=triggerdebug';
    }

    $oForm->validatePost();
    //$oJSON = new Services_JSON();
    $_POST['__notValidateThisFields__'] = (isset( $_POST['__notValidateThisFields__'] ) && $_POST['__notValidateThisFields__'] != '') ? $_POST['__notValidateThisFields__'] : $_POST['DynaformRequiredFields'];
    if ($missing_req_values = $oForm->validateRequiredFields( $_POST['form'], Bootstrap::json_decode( stripslashes( $_POST['__notValidateThisFields__'] ) ) )) {
        $fieldsRequired = Bootstrap::json_decode(str_replace(array("%27", "%39"), array("\"", "'"), $_POST["DynaformRequiredFields"]));

        foreach ($fieldsRequired as $key1 => $value1) {
           foreach ($missing_req_values as $key2 => $value2) {
                if ($value1->name == $value2) {
                    $missing_req_values[$key2] = $value1->label;
                }
           }
        }

        $_POST['next_step'] = $aNextStep;
        $_POST['previous_step'] = $oCase->getPreviousStep( $_SESSION['PROCESS'], $_SESSION['APPLICATION'], $_SESSION['INDEX'], $_SESSION['STEP_POSITION'] );
        $_POST['req_val'] = $missing_req_values;
        global $G_PUBLISH;
        $G_PUBLISH = new Publisher();
        $G_PUBLISH->AddContent( 'view', 'cases/missRequiredFields' );
        G::RenderPage( 'publish', 'blank' );
        exit( 0 );
    }

    G::header( 'location: ' . $aNextStep['PAGE'] );

} catch (Exception $e) {
    $G_PUBLISH = new Publisher();
    $aMessage = array ();
    $aMessage['MESSAGE'] = $e->getMessage();
    $G_PUBLISH->AddContent( 'xmlform', 'xmlform', 'login/showMessage', '', $aMessage );
    G::RenderPage( 'publish', 'blank' );
    die();
}

