<?php
require_once PATH_CORE . 'classes' . PATH_SEP . 'class.enterpriseUtils.php';
require_once PATH_CORE . 'classes' . PATH_SEP . 'class.pmLicenseManager.php';
require_once PATH_CORE . 'methods' . PATH_SEP . 'enterprise' . PATH_SEP . 'enterprise.php';
require_once PATH_CORE . 'classes' . PATH_SEP . 'model' . PATH_SEP . 'AddonsManagerPeer.php';

function runBgProcessmaker($task, $log)
{
    require_once (PATH_CORE . "bin/tasks/cliAddons.php");
    //require_once PATH_CORE . 'classes' . PATH_SEP . 'class.enterpriseUtils.php';


    /*
    $pmosFilename = PATH_TRUNK . "processmaker";
    $cmd          = "php -f \"$pmosFilename\" $task";

    if (substr(php_uname(), 0, 7) == "Windows"){
      pclose(popen("start /B ". $cmd, "r"));
    }
    else {
      $str = system("$cmd 1> \"$log.log\" 2> \"$log.err\" < /dev/null &", $retval);
    }
    */

    $task = str_replace("\"", null, $task);
    $data = explode(" ", $task);

    $elem = array_shift($data); //delete first element

    run_addon_core_install($data);
}

try {
    if (isset($_REQUEST["action"])) {
        $action = $_REQUEST["action"];
    } else {
        throw (new Exception("Action undefined"));
    }

    if (isset($_REQUEST['addon']) && isset($_REQUEST['store'])) {
        require_once (PATH_CORE . 'classes/model/AddonsManagerPeer.php');

        $addon   = AddonsManagerPeer::retrieveByPK($_REQUEST['addon'], $_REQUEST['store']);
        $addonId = $_REQUEST['addon'];
        $storeId = $_REQUEST['store'];

        if ($addon === null) {
            throw (new Exception("Unable to find addon (id: '{$_REQUEST['addon']}', store: '{$_REQUEST['store']}')"));
        }
    } else {
        $addon = null;
    }

    $result = array();

    switch (strtolower($action)) {
        case "importlicense":
            if (sizeof($_FILES) > 0) {
                $aInfoLoadFile  = $_FILES["upLicense"];
                $aExtentionFile = explode(".", $aInfoLoadFile["name"]);

                //validating the extention before to upload it
                if (trim($aExtentionFile[sizeof($aExtentionFile) - 1]) != "dat") {
                    //G::SendTemporalMessage("ID_ISNT_LICENSE", "tmp-info", "labels");
                    $result["errors"]  = "Filename does not end with .dat";
                    $result["success"] = false;
                } else {
                    $dir = PATH_DATA_SITE;
                    G::uploadFile($aInfoLoadFile["tmp_name"], $dir, $aInfoLoadFile["name"]);
                    //reading the file that was uploaded
                    $oPmLicenseManager = &pmLicenseManager::getSingleton();
                    $response = $oPmLicenseManager->installLicense($dir . $aInfoLoadFile["name"]);

                    ///////
                    //This command also find the following file "AddonsStore.php"
                    $licenseManager = &pmLicenseManager::getSingleton();

                    preg_match("/^license_(.*).dat$/", $licenseManager->file, $matches);
                    $realId = urlencode($matches[1]);

                    $addonLocation = "http://{$licenseManager->server}/syspmLicenseSrv/en/green/services/addonsStore?action=getInfo&licId=$realId";

                    ///////
                    $cnn = Propel::getConnection("workflow");

                    $oCriteriaSelect = new Criteria("workflow");
                    $oCriteriaSelect->add(AddonsStorePeer::STORE_ID, $licenseManager->id);

                    $oCriteriaUpdate = new Criteria("workflow");
                    $oCriteriaUpdate->add(AddonsStorePeer::STORE_ID, $licenseManager->id);
                    $oCriteriaUpdate->add(AddonsStorePeer::STORE_LOCATION, $addonLocation);

                    BasePeer::doUpdate($oCriteriaSelect, $oCriteriaUpdate, $cnn);

                    ///////
                    //$licenseManager = &pmLicenseManager::getSingleton();

                    //plugin.singleton //are all the plugins that are enabled in the SYS_SYS
                    $pluginRegistry = &PMPluginRegistry::getSingleton();

                    $arrayAddon = array();

                    //ee //all plugins enterprise installed in /processmaker/workflow/engine/plugins (no matter if they are enabled/disabled)
                    if (file_exists(PATH_DATA_SITE . "ee")) {
                        $arrayAddon = unserialize(trim(file_get_contents(PATH_DATA_SITE . "ee")));
                    }

                    foreach ($arrayAddon as $addon) {
                        $sFileName = substr($addon["sFilename"], 0, strpos($addon["sFilename"], "-"));

                        if (file_exists(PATH_PLUGINS . $sFileName . ".php")) {
                            $addonDetails = $pluginRegistry->getPluginDetails($sFileName . ".php");
                            $enabled = 0;

                            if ($addonDetails) {
                                $enabled = ($addonDetails->enabled)? 1 : 0;
                            }

                            if ($enabled == 1 && !in_array($sFileName, $licenseManager->features)) {
                                require_once (PATH_PLUGINS . $sFileName . ".php");

                                $pluginRegistry->disablePlugin($sFileName);
                            }
                        }
                    }

                    file_put_contents(PATH_DATA_SITE . "plugin.singleton", $pluginRegistry->serializeInstance());
                }
            }
            break;
        case "cancel":
            if ($addon === null) {
                throw new Exception("No addon specified to $action");
            }
            if ($addon->getAddonState() == "download") {
                $addon->setState("cancel");
            }
            break;
        case "uninstall":
            $status = 1;

            try {
                if ($addon === null) {
                    throw new Exception("No addon specified to $action");
                }

                $r = $addon->uninstall();

                $result["status"] = "OK";
            } catch (Exception $e) {
                $result["message"] = $e->getMessage();
                $status = 0;
            }

            if ($status == 0) {
                $result["status"] = "ERROR";
            }
            break;
        case "finish":
            if ($addon === null) {
                throw new Exception("No addon specified to $action");
            }
            $addon->setState();
            break;
        case "disable":
        case "enable":
            if ($addon === null) {
                throw new Exception("No addon specified to $action");
            }

            $result["success"] = $addon->setEnabled(($action == "enable"));

            if ($action == "enable") {
                G::auditLog("EnablePlugin", "Plugin Name: ".$_REQUEST['addon']);
            } else {
                G::auditLog("DisablePlugin", "Plugin Name: ".$_REQUEST['addon']);
            }

            break;
        case "install":
            $status = 1;

            try {
                if (EnterpriseUtils::getInternetConnection() == 0) {
                    throw (new Exception("Enterprise Plugins Manager no connected to internet."));
                }

                ///////
                $aux = explode("?", $addon->getAddonDownloadUrl());
                $url = $aux[0];

                if (EnterpriseUtils::checkConnectivity($url) == false) {
                    throw (new Exception("Server $url not available."));
                }

                if ($addon === null) {
                    throw new Exception("No addon specified to $action");
                }

                ///////
                $workspace = SYS_SYS;
                $dbAdapter = DB_ADAPTER;

                $addon->setAddonState("download-start");
                $addon->save();

                $log = $addon->getDownloadDirectory() . "/download";
                runBgProcessmaker("addon-install \"$workspace\" \"$storeId\" \"$addonId\" \"$dbAdapter\"", $log);

                //Check if the background process started successfully.
                $failed      = false;
                $max_retries = 15;
                $retries     = 0;

                while (true) {
                    sleep(1);
                    $addon->refresh();

                    if ($addon->getAddonState() != "download-start") {
                        break;
                    }

                    //$logContents = file_get_contents("$log.log", false, NULL, 0, 10);
                    //if (!empty($logContents))
                    //  break;

                    $retries += 1;

                    if ($retries > $max_retries) {
                        $failed = true;
                        break;
                    }
                }

                //if ($failed) {
                //    //$addon->clearState(); //clearState no found
                //    $result["success"] = false;
                //}

                $result["status"] = "OK";
            } catch (Exception $e) {
                $result["message"] = $e->getMessage();
                $status = 0;
            }

            if ($status == 0) {
                $result["status"] = "ERROR";
            }
            break;
        case "available":
            $addonId = $_POST["addonId"];

            $response = array();
            $status = 1;

            try {
                if (EnterpriseUtils::getInternetConnection() == 0) {
                    throw (new Exception("Enterprise Plugins Manager no connected to internet."));
                }

                ///////
                $licenseManager = &pmLicenseManager::getSingleton();
                $server = $licenseManager->server;

                $url = "http://$server/syspmLicenseSrv/en/green/services/rest";

                if (EnterpriseUtils::checkConnectivity($url) == false) {
                    throw (new Exception("Server \"$server\" not available."));
                }

                ///////
                $boundary = "---------------------" . substr(md5(rand(0, 32000)), 0, 10);
                $data = null;

                $data = $data . "--$boundary\n";
                $data = $data . "Content-Disposition: form-data; name=\"action\"\n\n" . "requestToSales" . "\n";
                $data = $data . "--$boundary\n";
                $data = $data . "Content-Disposition: form-data; name=\"OBJ_NAME\"\n\n" . $addonId . "\n";
                $data = $data . "--$boundary\n";

                ///////
                //$licenseManager = &pmLicenseManager::getSingleton();
                $activeLicense = $licenseManager->getActiveLicense();

                $data = $data . "Content-Disposition: form-data; name=\"licenseFile\"; filename=\"" . $licenseManager->file . "\"\n";
                $data = $data . "Content-Type: text/plain\n";
                $data = $data . "Content-Transfer-Encoding: binary\n\n";
                $data = $data . file_get_contents($activeLicense["LICENSE_PATH"]) . "\n";
                $data = $data . "--$boundary\n";

                ///////
                $option = array(
                    "http" => array(
                        "method" => "POST",
                        "header" => "Content-Type: multipart/form-data; boundary=" . $boundary,
                        "content" => $data
                    )
                );

                // Proxy settings
                $sysConf = System::getSystemConfiguration();
                if ($sysConf['proxy_host'] != '') {
                    if (!is_array($option['http'])) {
                        $option['http'] = array();
                    }
                    $option['http']['request_fulluri'] = true;
                    $option['http']['proxy'] = 'tcp://' . $sysConf['proxy_host'] . ($sysConf['proxy_port'] != '' ? ':' . $sysConf['proxy_port'] : '');
                    if ($sysConf['proxy_user'] != '') {
                        if (!isset($option['http']['header'])) {
                            $option['http']['header'] = '';
                        }
                        $option['http']['header'] .= 'Proxy-Authorization: Basic ' . base64_encode($sysConf['proxy_user'] . ($sysConf['proxy_pass'] != '' ? ':' . $sysConf['proxy_pass'] : ''));
                    }
                }

                $context = stream_context_create($option);

                ///////
                $fileData = file_get_contents($url, false, $context);

                //////////
                $r = G::json_decode($fileData);

                if ($r->status == "OK") {
                    $response["status"] = $r->status; //OK
                } else {
                    throw (new Exception($r->message));
                }
            } catch (Exception $e) {
                $response["message"] = $e->getMessage();
                $status = 0;
            }

            if ($status == 0) {
                $response["status"] = "ERROR";
            }

            echo G::json_encode($response);
            exit(0);
            break;
        case "addonslist":
            $type = (isset($_REQUEST['type'])) ?  $_REQUEST['type']: 'plugin';
            $result = AddonsStore::addonList($type);
            break;
            break;
        default:
            throw (new Exception("Action \"$action\" is not valid"));
    }

    if (!isset($result["success"])) {
        $result["success"] = true;
    }

    if (isset($result["addons"])) {
        $result["addons"] = array_values($result["addons"]);
    } else {
        $result["addons"] = array();
    }
    echo G::json_encode($result);

} catch (Exception $e) {
    echo G::json_encode(array("success" => false, "errors" => $e->getMessage()));
}

