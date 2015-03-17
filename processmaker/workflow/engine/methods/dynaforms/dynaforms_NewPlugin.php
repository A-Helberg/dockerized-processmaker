<?php
/**
 * dynaforms_Edit.php
 *
 * ProcessMaker Open Source Edition
 * Copyright (C) 2004 - 2008 Colosa Inc.23
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

//call plugin
//  $oPluginRegistry = &PMPluginRegistry::getSingleton();
//  $existsDynaforms = $oPluginRegistry->existsTrigger(PM_NEW_DYNAFORM_LIST );


//for now, we are going with the default list, because the plugin is not complete
include ('dynaforms_Edit.php');
die();

//---*****************


if (! $existsDynaforms) {
    include ('dynaforms_Edit.php');
    die();
}
print "Existe";
print (class_exists( 'folderData' )) ;

die();
//end plugin
if (($RBAC_Response = $RBAC->userCanAccess( "PM_FACTORY" )) != 1) {
    return $RBAC_Response;
}

    //G::genericForceLogin( 'WF_MYINFO' , 'login/noViewPage', $urlLogin =n 'login/login' );


require_once ('classes/model/Dynaform.php');

$dynUid = (isset( $_GET['DYN_UID'] )) ? urldecode( $_GET['DYN_UID'] ) : '';
$dynaform = new dynaform();
if ($dynUid == '') {
    $aFields['DYN_UID'] = $dynUid;
} else {
    $aFields = $dynaform->load( $dynUid );
}
$aFields['PRO_UID'] = isset( $dynaform->Fields['PRO_UID'] ) ? $dynaform->Fields['PRO_UID'] : $_GET['PRO_UID'];

$G_PUBLISH = new Publisher();
$G_PUBLISH->AddContent( 'xmlform', 'xmlform', 'dynaforms/dynaforms_Edit', '', $aFields, SYS_URI . 'dynaforms/dynaforms_Save' );

G::RenderPage( "publish-raw", "raw" );

