<?php

$action = isset( $_GET['action'] ) ? G::sanitizeInput($_GET['action'])  : 'default';

G::LoadClass( 'case' );
G::LoadClass( 'configuration' );
$userId = isset( $_SESSION['USER_LOGGED'] ) ? $_SESSION['USER_LOGGED'] : '00000000000000000000000000000000';
switch ($action) {
    case 'getAllCounters':
        getAllCounters();
        break;
    case 'getProcess':
        getProcess();
        break;
    default: //this is the starting call
        getLoadTreeMenuData();
        break;
}

function getLoadTreeMenuData ()
{
    header( "content-type: text/xml" );

    global $G_TMP_MENU;
    $oMenu = new Menu();
    $oMenu->load( 'cases' );

    $oCases = new Cases();
    $aTypes = Array ('to_do','draft','cancelled','sent','paused','completed','selfservice');
    //'to_revise',
    //'to_reassign'
    $aTypesID = Array ('CASES_INBOX' => 'to_do','CASES_DRAFT' => 'draft','CASES_CANCELLED' => 'cancelled','CASES_SENT' => 'sent','CASES_PAUSED' => 'paused','CASES_COMPLETED' => 'completed','CASES_SELFSERVICE' => 'selfservice');
    //'CASES_TO_REVISE'=>'to_revise',
    //'CASES_TO_REASSIGN'=>'to_reassign'
        $list = array ();
    $list['count'] = ' ';

    $empty = array ();
    foreach ($aTypes as $key => $val) {
        $empty[$val] = $list;
    }

    $aCount = $empty; //$oCases->getAllConditionCasesCount($aTypes, true);
    $processNameMaxSize = 20;

    //now drawing the treeview using the menu options from menu/cases.php
    $menuCases = array ();
    for ($i = 0; $i < count($oMenu->Options); $i++) {
        if ($oMenu->Types[$i] == 'blockHeader') {
            $CurrentBlockID = $oMenu->Id[$i];
            $menuCases[$CurrentBlockID]['blockTitle'] = $oMenu->Labels[$i];
            if ($oMenu->Options[$i] != "") {
                $menuCases[$CurrentBlockID]['link'] = $oMenu->Options[$i];
            }
        } elseif ($oMenu->Types[$i] == 'blockNestedTree') {
            $CurrentBlockID = $oMenu->Id[$i];
            $menuCases[$CurrentBlockID]['blockTitle'] = $oMenu->Labels[$i];
            $menuCases[$CurrentBlockID]['blockType'] = $oMenu->Types[$i];
            $menuCases[$CurrentBlockID]['loaderurl'] = $oMenu->Options[$i];
        } elseif ($oMenu->Types[$i] == 'blockHeaderNoChild') {
            $CurrentBlockID = $oMenu->Id[$i];
            $menuCases[$CurrentBlockID]['blockTitle'] = $oMenu->Labels[$i];
            $menuCases[$CurrentBlockID]['blockType'] = $oMenu->Types[$i];
            $menuCases[$CurrentBlockID]['link'] = $oMenu->Options[$i];
        } elseif ($oMenu->Types[$i] == 'rootNode') {
            $menuCases[$CurrentBlockID]['blockItems'][$oMenu->Id[$i]] = array (
                'label' => $oMenu->Labels[$i],
                'link' => $oMenu->Options[$i],
                'icon' => (isset($oMenu->Icons[$i]) && $oMenu->Icons[$i] != '') ? $oMenu->Icons[$i] : 'kcmdf.png'
            );

            $index = $i;
            list($childs, $index) = getChilds($oMenu, ++$index);
            
            $menuCases[$CurrentBlockID]['blockItems'][$oMenu->Id[$i]]['childs'] = $childs;

            $i = $index;
        } else {
            $menuCases[$CurrentBlockID]['blockItems'][$oMenu->Id[$i]] = array (
                'label' => $oMenu->Labels[$i],
                'link' => $oMenu->Options[$i],
                'icon' => (isset($oMenu->Icons[$i]) && $oMenu->Icons[$i] != '') ? $oMenu->Icons[$i] : 'kcmdf.png'
            );

            if (isset( $aTypesID[$oMenu->Id[$i]] )) {
                $menuCases[$CurrentBlockID]['blockItems'][$oMenu->Id[$i]]['cases_count'] = $aCount[$aTypesID[$oMenu->Id[$i]]]['count'];
            }
        }
    }

    // Build xml nodes for a specific child node by its "id" on var "$_POST['node']" passed in a POST request
    if (isset($_POST['node']) && in_array($_POST['node'], array_keys($menuCases))) {
        $xml = new SimpleXMLElement('<?xml version="1.0" standalone="yes"?><menu_cases />');

        if (array_key_exists('blockItems', $menuCases[$_POST['node']]) && is_array($menuCases[$_POST['node']]['blockItems'])) {
            foreach ($menuCases[$_POST['node']]['blockItems'] as $key => $item) {
                $option = $xml->addChild('option');
                $option->addAttribute('id', $key);
                $option->addAttribute('title', $item['label']);
                $option->addAttribute('url', $item['link']);

                if (! empty($item['cases_count'])) {
                    $option->addAttribute('cases_count', $item['cases_count']);
                }
            }
        }

        echo $xml->asXML();
        die;
    }

    // Build xml document for all tree nodes
    $xml = new SimpleXMLElement('<?xml version="1.0" standalone="yes"?><menu_cases />');
    foreach ($menuCases as $menuId => $menuBlock) {
        if (isset($menuBlock['blockItems']) && count($menuBlock['blockItems']) > 0) {
            // adding "menu_block" node
            $menuBlockNode = $xml->addChild('menu_block');
            $menuBlockNode->addAttribute('id', $menuId);
            $menuBlockNode->addAttribute('blockTitle', $menuBlock['blockTitle']);

            if (! empty($menuBlock['link'])) {
                $menuBlockNode->addAttribute('url', $menuBlock['link']);
            }

            // adding "menu_block" childs nodes
            foreach ($menuBlock['blockItems'] as $id => $menu)
            {
                if (! empty($menu['childs'])) {
                    $rootNode = $menuBlockNode->addChild('menu_block');
                    $rootNode->addAttribute('id', $id);
                    $rootNode->addAttribute('title', $menu['label']);
                    $rootNode->addAttribute('url', $menu['link']);
                    $rootNode->addAttribute('expanded', true);

                    foreach ($menu['childs'] as $id => $child) {
                        $childNode = $rootNode->addChild('option');
                        $childNode->addAttribute('id', $id);
                        $childNode->addAttribute('title', $child['label']);
                        $childNode->addAttribute('url', $child['link']);
                    }

                    continue;
                }

                $option = $menuBlockNode->addChild('option');
                $option->addAttribute('id', $id);
                $option->addAttribute('title', $menu['label']);
                $option->addAttribute('url', $menu['link']);

                if (! empty($menu['cases_count'])) {
                    $option->addAttribute('cases_count', $menu['cases_count']);
                }
            }
        } elseif (isset($menuBlock['blockType']) && $menuBlock['blockType'] == "blockNestedTree") {
            $menuBlockNode = $xml->addChild('menu_block');
            $menuBlockNode->addAttribute('id', $menuId);
            $menuBlockNode->addAttribute('folderId', "0");
            $menuBlockNode->addAttribute('blockTitle', $menuBlock['blockTitle']);
            $menuBlockNode->addAttribute('blockNestedTree', $menuBlock['loaderurl']);
        } elseif (isset($menuBlock['blockType']) && $menuBlock['blockType'] == "blockHeaderNoChild") {
            $menuBlockNode = $xml->addChild('menu_block');
            $menuBlockNode->addAttribute('id', $menuId);
            $menuBlockNode->addAttribute('blockTitle', $menuBlock['blockTitle']);
            $menuBlockNode->addAttribute('blockHeaderNoChild', "blockHeaderNoChild");
            $menuBlockNode->addAttribute('url', $menuBlock['link']);
        }
    }

    echo $xml->asXML();
    die;

    // Build xml document for all tree nodes
    /*$xml = '<menu_cases>';
    $i = 0;
    foreach ($menuCases as $menu => $aMenuBlock) {
        if (isset( $aMenuBlock['blockItems'] ) && sizeof( $aMenuBlock['blockItems'] ) > 0) {
            $urlProperty = "";
            if ((isset( $aMenuBlock['link'] )) && ($aMenuBlock['link'] != "")) {
                $urlProperty = "url='" . $aMenuBlock['link'] . "'";
            }
            $xml .= '<menu_block blockTitle="' . $aMenuBlock['blockTitle'] . '" id="' . $menu . '" ' . $urlProperty . '>';
            foreach ($aMenuBlock['blockItems'] as $id => $aMenu) {
                $i ++;
                if (isset( $aMenu['cases_count'] ) && $aMenu['cases_count'] !== '') {
                    $nofifier = "cases_count=\"{$aMenu['cases_count']}\" ";
                } else {
                    $nofifier = '';
                }
                $xml .= '<option title="' . $aMenu['label'] . '" id="' . $id . '" ' . $nofifier . ' url="' . $aMenu['link'] . '">';
                $xml .= '</option>';
            }
            $xml .= '</menu_block>';
        } elseif (isset( $aMenuBlock['blockType'] ) && $aMenuBlock['blockType'] == "blockNestedTree") {
            $xml .= '<menu_block blockTitle="' . $aMenuBlock['blockTitle'] . '" blockNestedTree = "' . $aMenuBlock['loaderurl'] . '" id="' . $menu . '" folderId="0">';
            $xml .= '</menu_block>';
        } elseif (isset( $aMenuBlock['blockType'] ) && $aMenuBlock['blockType'] == "blockHeaderNoChild") {
            $xml .= '<menu_block blockTitle="' . $aMenuBlock['blockTitle'] . '" blockHeaderNoChild="blockHeaderNoChild" url = "' . $aMenuBlock['link'] . '" id="' . $menu . '">';
            //$xml .= '<option title="" id="" ></option>';
            $xml .= '</menu_block>';
        }
    }
    $xml .= '</menu_cases>';

    print $xml;*/
}

// get the process summary of specific case list type,
function getProcess ()
{
    global $G_TMP_MENU;
    global $userId;
    if (! isset( $_GET['item'] )) {
        die();
    }

    $oMenu = new Menu();
    $oMenu->load( 'cases' );
    $type = $_GET['item'];
    $oCases = new AppCacheView();

    $aTypesID = array ();
    $aTypesID['CASES_INBOX'] = 'to_do';
    $aTypesID['CASES_DRAFT'] = 'draft';
    $aTypesID['CASES_CANCELLED'] = 'cancelled';
    $aTypesID['CASES_SENT'] = 'sent';
    $aTypesID['CASES_PAUSED'] = 'paused';
    $aTypesID['CASES_COMPLETED'] = 'completed';
    $aTypesID['CASES_SELFSERVICE'] = 'selfservice';
    //$aTypesID['CASES_TO_REVISE']   = 'to_revise';
    //$aTypesID['CASES_TO_REASSIGN'] = 'to_reassign';
    $aTypesID = Array ('CASES_INBOX' => 'to_do','CASES_DRAFT' => 'draft','CASES_CANCELLED' => 'cancelled','CASES_SENT' => 'sent','CASES_PAUSED' => 'paused','CASES_COMPLETED' => 'completed','CASES_SELFSERVICE' => 'selfservice','CASES_TO_REVISE' => 'to_revise','CASES_TO_REASSIGN' => 'to_reassign');

    $aCount = $oCases->getAllCounters( Array ($aTypesID[$type]
    ), $userId, true );

    $response = Array ();
    //disabling the summary...
    /*
    $i=0;
    foreach($aCount[$aTypesID[$type]]['sumary'] as $PRO_UID=>$process){
      //{"text":"state","id":"src\/state","cls":"folder", loaded:true},
      $response[$i] = new stdClass();
      $response[$i]->text = $process['name'] . ' ('.$process['count'].')';
      $response[$i]->id = $process['name'];
      $response[$i]->cls = 'folder';
      $response[$i]->loaded = true;
      $i++;
    }
    */
    //ordering
    /*for($i=0; $i<=count($response)-1; $i++){
      for($j=$i+1; $j<=count($response); $j++){

        echo $response[$j]->text .'<'. $response[$i]->text;
        if($response[$j]->text[0] < $response[$i]->text[0]){
          $x = $response[$i];
          $response[$i] = $response[$j];
          $response[$j] = $x;
        }
      }
    }*/
    echo G::json_encode( $response );
}

function getAllCounters ()
{
    $userUid = (isset( $_SESSION['USER_LOGGED'] ) && $_SESSION['USER_LOGGED'] != '') ? $_SESSION['USER_LOGGED'] : null;
    $oAppCache = new AppCacheView();
    $aTypes = Array ();
    $aTypes['to_do'] = 'CASES_INBOX';
    $aTypes['draft'] = 'CASES_DRAFT';
    $aTypes['cancelled'] = 'CASES_CANCELLED';
    $aTypes['sent'] = 'CASES_SENT';
    $aTypes['paused'] = 'CASES_PAUSED';
    $aTypes['completed'] = 'CASES_COMPLETED';
    $aTypes['selfservice'] = 'CASES_SELFSERVICE';
    //$aTypes['to_revise']   = 'CASES_TO_REVISE';
    //$aTypes['to_reassign'] = 'CASES_TO_REASSIGN';
    $solrEnabled = false;

    if ((($solrConf = System::solrEnv()) !== false)) {
        G::LoadClass( 'AppSolr' );
        $ApplicationSolrIndex = new AppSolr( $solrConf['solr_enabled'], $solrConf['solr_host'], $solrConf['solr_instance'] );

        if ($ApplicationSolrIndex->isSolrEnabled() && $solrConf['solr_enabled'] == true) {
            $solrEnabled = true;
        }
    }

    if ($solrEnabled) {
        $aCount = $ApplicationSolrIndex->getCasesCount( $userUid );

        //get paused count
        $aCountMissing = $oAppCache->getAllCounters( array ('completed','cancelled'), $userUid );

        $aCount = array_merge( $aCount, $aCountMissing );
    } else {

        $aCount = $oAppCache->getAllCounters( array_keys( $aTypes ), $userUid );

    }

    $response = Array ();
    $i = 0;
    foreach ($aCount as $type => $count) {
        $response[$i] = new stdclass();
        $response[$i]->item = $aTypes[$type];
        $response[$i]->count = $count;
        $i ++;
    }
    echo G::json_encode( $response );
}

function getChilds($menu, $index)
{
    $childs = array();

    for ($i = $index; $i < count($menu->Options); $i++) {
        if ($menu->Types[$i] == 'childNode') {
            
            $childs[$menu->Id[$i]] = array(
                'label' => $menu->Labels[$i],
                'link' => $menu->Options[$i],
                'icon' => ''
            );
        } else {
            //TODO we can add more recursive logic here to enable more childs levels
            break;
        }
    }

    return array($childs, --$i);
}

