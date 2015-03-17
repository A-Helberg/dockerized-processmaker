<?php
/**
 * processes_List.php
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

require_once 'classes/model/Process.php';

$start = isset( $_POST['start'] ) ? $_POST['start'] : 0;
$limit = isset( $_POST['limit'] ) ? $_POST['limit'] : '';
$dir = isset( $_POST['dir'] ) ? $_POST['dir'] : 'ASC';
$sort = isset( $_POST['sort'] ) ? $_POST['sort'] : '';

$oProcess = new Process();
$oProcess->dir = $dir;
$oProcess->sort = $sort;

//$memcache = & PMmemcached::getSingleton( SYS_SYS );

$memkey = 'no memcache';
$memcacheUsed = 'not used';
$totalCount = 0;
if (isset( $_POST['category'] ) && $_POST['category'] !== '<reset>') {
    if (isset( $_POST['processName'] ))
        $proData = $oProcess->getAllProcesses( $start, $limit, $_POST['category'], $_POST['processName']);
    else
        $proData = $oProcess->getAllProcesses( $start, $limit, $_POST['category']);
} else {
    if (isset( $_POST['processName'] )) {
        $memkey = 'processList-' . $start . '-' . $limit . '-' . $_POST['processName'];
        $memcacheUsed = 'yes';
        $proData = $memcache->get( $memkey );
        if ($proData === false) {
            $proData = $oProcess->getAllProcesses( $start, $limit, null, $_POST['processName']);
            $memcache->set( $memkey, $proData, PMmemcached::ONE_HOUR );
            $totalCount = count($proData);
            $proData = array_splice($proData, $start, $limit);
            $memcacheUsed = 'no';
        } else {
            $proData = $oProcess->orderMemcache($proData, $start, $limit);
            $totalCount = $proData->totalCount;
            $proData = $proData->dataMemcache;
        }
    } else {
        $memkey = 'processList-allProcesses-' . $start . '-' . $limit;
        $memkeyTotal = $memkey . '-total';
        $memcacheUsed = 'yes';
        if (($proData = $memcache->get( $memkey )) === false || ($totalCount = $memcache->get( $memkeyTotal )) === false) {
            $proData = $oProcess->getAllProcesses( $start, $limit, null, null, true, false, $_SESSION["USER_LOGGED"]);
            $totalCount = count($proData);
            $proData = array_splice($proData, $start, $limit);
            $memcache->set( $memkey, $proData, PMmemcached::ONE_HOUR );
            $memcache->set( $memkeyTotal, $totalCount, PMmemcached::ONE_HOUR );
            $memcacheUsed = 'no';
        } else {
        	$proData = $oProcess->orderMemcache($proData, $start, $limit);
            $totalCount = $proData->totalCount;
            $proData = $proData->dataMemcache;
       }
    }
}
$r = new stdclass();
$r->memkey = $memkey;
$r->memcache = $memcacheUsed;
$r->data = $proData;
$r->totalCount = $totalCount;

echo G::json_encode( $r );
