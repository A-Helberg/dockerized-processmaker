<?php
 /**
  * cron_single.php
  * @package workflow-engine-bin
  */
 
 if (!defined('SYS_LANG')) {
     define('SYS_LANG', 'en');
 }
 
 if (!defined('PATH_HOME')) {
     if (!defined('PATH_SEP')) {
         define('PATH_SEP', (substr(PHP_OS, 0, 3) == 'WIN') ? '\\' : '/');
     }
 
     $pathServices = 'engine' . PATH_SEP . 'methods' . PATH_SEP . 'services';
     $docuroot     = explode(PATH_SEP, str_replace($pathServices, '', dirname(__FILE__)));
 
     array_pop($docuroot);
     array_pop($docuroot);
 
     $pathHome = implode(PATH_SEP, $docuroot) . PATH_SEP;
 
     //try to find automatically the trunk directory where are placed the RBAC and Gulliver directories
     //in a normal installation you don't need to change it.
 
     array_pop($docuroot);
 
     $pathTrunk = implode(PATH_SEP, $docuroot) . PATH_SEP;
 
     array_pop($docuroot);
 
     $pathOutTrunk = implode(PATH_SEP, $docuroot) . PATH_SEP;
 
     //to do: check previous algorith for Windows  $pathTrunk = "c:/home/";
 
     define('PATH_HOME', $pathHome);
     define('PATH_TRUNK', $pathTrunk);
     define('PATH_OUTTRUNK', $pathOutTrunk);
 
     require_once (PATH_HOME . 'engine' . PATH_SEP . 'config' . PATH_SEP . 'paths.php');
     require_once PATH_TRUNK . "framework/src/Maveriks/Util/ClassLoader.php";
 
     G::LoadThirdParty('pear/json','class.json');
     G::LoadThirdParty('smarty/libs','Smarty.class');
     G::LoadSystem('error');
     G::LoadSystem('dbconnection');
     G::LoadSystem('dbsession');
     G::LoadSystem('dbrecordset');
     G::LoadSystem('dbtable');
     G::LoadSystem('rbac' );
     G::LoadSystem('publisher');
     G::LoadSystem('templatePower');
     G::LoadSystem('xmlDocument');
     G::LoadSystem('xmlform');
     G::LoadSystem('xmlformExtension');
     G::LoadSystem('form');
     G::LoadSystem('menu');
     G::LoadSystem("xmlMenu");
     G::LoadSystem('dvEditor');
     G::LoadSystem('table');
     G::LoadSystem('pagedTable');
     G::LoadClass ( 'system' );
     require_once ( "propel/Propel.php" );
     require_once ( "creole/Creole.php" );
 
     $config = System::getSystemConfiguration();
 
     $e_all  = defined('E_DEPRECATED') ? E_ALL  & ~E_DEPRECATED : E_ALL;
     $e_all  = defined('E_STRICT')     ? $e_all & ~E_STRICT     : $e_all;
     $e_all  = $config['debug']        ? $e_all                 : $e_all & ~E_NOTICE;
 
     // Do not change any of these settings directly, use env.ini instead
     ini_set('display_errors', $config['debug']);
     ini_set('error_reporting', $e_all);
     ini_set('short_open_tag', 'On');
     ini_set('default_charset', "UTF-8");
     ini_set('memory_limit', $config['memory_limit']);
     ini_set('soap.wsdl_cache_enabled', $config['wsdl_cache']);
     ini_set('date.timezone', $config['time_zone']);
 
     define ('DEBUG_SQL_LOG', $config['debug_sql']);
     define ('DEBUG_TIME_LOG', $config['debug_time']);
     define ('DEBUG_CALENDAR_LOG', $config['debug_calendar']);
     define ('MEMCACHED_ENABLED',  $config['memcached']);
     define ('MEMCACHED_SERVER',   $config['memcached_server']);
     define ('TIME_ZONE', $config['time_zone']);
 }
 
 require_once (PATH_GULLIVER . PATH_SEP . 'class.bootstrap.php');
 //define( 'PATH_GULLIVER_HOME', PATH_TRUNK . 'gulliver' . PATH_SEP );
 
 spl_autoload_register(array('Bootstrap', 'autoloadClass'));
 
 //DATABASE propel classes used in 'Cases' Options
 Bootstrap::registerClass('Entity_Base',        PATH_HOME . "engine/classes/entities/Base.php");
 
 Bootstrap::registerClass('BaseContent',        PATH_HOME . "engine/classes/model/om/BaseContent.php");
 Bootstrap::registerClass('Content',            PATH_HOME . "engine/classes/model/Content.php");
 Bootstrap::registerClass('BaseContentPeer',    PATH_HOME . "engine/classes/model/om/BaseContentPeer.php");
 Bootstrap::registerClass('ContentPeer',        PATH_HOME . "engine/classes/model/ContentPeer.php");
 Bootstrap::registerClass('BaseApplication',    PATH_HOME . "engine/classes/model/om/BaseApplication.php");
 Bootstrap::registerClass('ApplicationPeer',    PATH_HOME . "engine/classes/model/ApplicationPeer.php");
 Bootstrap::registerClass('Application',        PATH_HOME . "engine/classes/model/Application.php");
 
 Bootstrap::registerClass('BaseAppDelegation',  PATH_HOME . "engine/classes/model/om/BaseAppDelegation.php");
 Bootstrap::registerClass('BaseHoliday',        PATH_HOME . "engine/classes/model/om/BaseHoliday.php");
 Bootstrap::registerClass('BaseHolidayPeer',    PATH_HOME . "engine/classes/model/om/BaseHolidayPeer.php");
 Bootstrap::registerClass('BaseTask',           PATH_HOME . "engine/classes/model/om/BaseTask.php");
 Bootstrap::registerClass('BaseTaskPeer',       PATH_HOME . "engine/classes/model/om/BaseTaskPeer.php");
 Bootstrap::registerClass('HolidayPeer',        PATH_HOME . "engine/classes/model/HolidayPeer.php");
 Bootstrap::registerClass('Holiday',            PATH_HOME . "engine/classes/model/Holiday.php");
 Bootstrap::registerClass('Task',               PATH_HOME . "engine/classes/model/Task.php");
 Bootstrap::registerClass('TaskPeer',           PATH_HOME . "engine/classes/model/TaskPeer.php");
 Bootstrap::registerClass('dates',              PATH_HOME . "engine/classes/class.dates.php");
 Bootstrap::registerClass('calendar',           PATH_HOME . "engine/classes/class.calendar.php");
 Bootstrap::registerClass('AppDelegation',      PATH_HOME . "engine/classes/model/AppDelegation.php");
 Bootstrap::registerClass('BaseAppDelegationPeer',PATH_HOME . "engine/classes/model/om/BaseAppDelegationPeer.php");
 Bootstrap::registerClass('AppDelegationPeer',  PATH_HOME . "engine/classes/model/AppDelegationPeer.php");
 Bootstrap::registerClass('BaseAppDelay',       PATH_HOME . "engine/classes/model/om/BaseAppDelay.php");
 Bootstrap::registerClass('AppDelayPeer',       PATH_HOME . "engine/classes/model/AppDelayPeer.php");
 Bootstrap::registerClass('AppDelay',           PATH_HOME . "engine/classes/model/AppDelay.php");
 Bootstrap::registerClass('BaseAdditionalTables',PATH_HOME . "engine/classes/model/om/BaseAdditionalTables.php");
 Bootstrap::registerClass('AdditionalTables',   PATH_HOME . "engine/classes/model/AdditionalTables.php");
 Bootstrap::registerClass('BaseAppCacheView',   PATH_HOME . "engine/classes/model/om/BaseAppCacheView.php");
 Bootstrap::registerClass('AppCacheView',       PATH_HOME . "engine/classes/model/AppCacheView.php");
 Bootstrap::registerClass('BaseAppCacheViewPeer',PATH_HOME . "engine/classes/model/om/BaseAppCacheViewPeer.php");
 Bootstrap::registerClass('AppCacheViewPeer',   PATH_HOME . "engine/classes/model/AppCacheViewPeer.php");
 
 /*----------------------------------********---------------------------------*/
 
 Bootstrap::registerClass('BaseInputDocument',  PATH_HOME . "engine/classes/model/om/BaseInputDocument.php");
 Bootstrap::registerClass('InputDocument',      PATH_HOME . "engine/classes/model/InputDocument.php");
 Bootstrap::registerClass('BaseAppDocument',    PATH_HOME . "engine/classes/model/om/BaseAppDocument.php");
 Bootstrap::registerClass('AppDocument',        PATH_HOME . "engine/classes/model/AppDocument.php");
 Bootstrap::registerClass('AppDocumentPeer',    PATH_HOME . "engine/classes/model/AppDocumentPeer.php");
 
 Bootstrap::registerClass('BaseAppEvent',       PATH_HOME . "engine/classes/model/om/BaseAppEvent.php");
 Bootstrap::registerClass('AppEvent',           PATH_HOME . "engine/classes/model/AppEvent.php");
 Bootstrap::registerClass('AppEventPeer',       PATH_HOME . "engine/classes/model/AppEventPeer.php");
 
 Bootstrap::registerClass('BaseAppHistory',     PATH_HOME . "engine/classes/model/om/BaseAppHistory.php");
 Bootstrap::registerClass('AppHistory',         PATH_HOME . "engine/classes/model/AppHistory.php");
 Bootstrap::registerClass('AppHistoryPeer',     PATH_HOME . "engine/classes/model/AppHistoryPeer.php");
 
 Bootstrap::registerClass('BaseAppFolder',      PATH_HOME . "engine/classes/model/om/BaseAppFolder.php");
 Bootstrap::registerClass('AppFolder',          PATH_HOME . "engine/classes/model/AppFolder.php");
 Bootstrap::registerClass('AppFolderPeer',      PATH_HOME . "engine/classes/model/AppFolderPeer.php");
 
 Bootstrap::registerClass('BaseAppMessage',     PATH_HOME . "engine/classes/model/om/BaseAppMessage.php");
 Bootstrap::registerClass('AppMessage',         PATH_HOME . "engine/classes/model/AppMessage.php");
 
 Bootstrap::registerClass('BaseAppMessagePeer', PATH_HOME . "engine/classes/model/om/BaseAppMessagePeer.php");
 Bootstrap::registerClass('AppMessagePeer',     PATH_HOME . "engine/classes/model/AppMessagePeer.php");
 
 Bootstrap::registerClass('BaseAppNotesPeer',    PATH_HOME . "engine/classes/model/om/BaseAppNotesPeer.php");
 Bootstrap::registerClass('AppNotesPeer',        PATH_HOME . "engine/classes/model/AppNotesPeer.php");
 
 Bootstrap::registerClass('BaseAppNotes',        PATH_HOME . "engine/classes/model/om/BaseAppNotes.php");
 Bootstrap::registerClass('AppNotes',            PATH_HOME . "engine/classes/model/AppNotes.php");
 
 Bootstrap::registerClass('BaseAppOwner',        PATH_HOME . "engine/classes/model/om/BaseAppOwner.php");
 Bootstrap::registerClass('AppOwner',            PATH_HOME . "engine/classes/model/AppOwner.php");
 Bootstrap::registerClass('AppOwnerPeer',        PATH_HOME . "engine/classes/model/AppOwnerPeer.php");
 
 Bootstrap::registerClass('BaseAppSolrQueue',    PATH_HOME . "engine/classes/model/om/BaseAppSolrQueue.php");
 Bootstrap::registerClass('Entity_AppSolrQueue', PATH_HOME . "engine/classes/entities/AppSolrQueue.php");
 Bootstrap::registerClass('AppSolrQueue',        PATH_HOME . "engine/classes/model/AppSolrQueue.php");
 Bootstrap::registerClass('AppSolrQueuePeer',    PATH_HOME . "engine/classes/model/AppSolrQueuePeer.php");
 
 Bootstrap::registerClass('BaseAppThread',       PATH_HOME . "engine/classes/model/om/BaseAppThread.php");
 Bootstrap::registerClass('AppThread',           PATH_HOME . "engine/classes/model/AppThread.php");
 Bootstrap::registerClass('AppThreadPeer',       PATH_HOME . "engine/classes/model/AppThreadPeer.php");
 
 Bootstrap::registerClass('BaseCaseScheduler',   PATH_HOME . "engine/classes/model/om/BaseCaseScheduler.php");
 Bootstrap::registerClass('CaseScheduler',       PATH_HOME . "engine/classes/model/CaseScheduler.php");
 
 Bootstrap::registerClass('BaseCaseSchedulerPeer',PATH_HOME . "engine/classes/model/om/BaseCaseSchedulerPeer.php");
 Bootstrap::registerClass('CaseSchedulerPeer',    PATH_HOME . "engine/classes/model/CaseSchedulerPeer.php");
 
 Bootstrap::registerClass('BaseCaseTracker',     PATH_HOME . "engine/classes/model/om/BaseCaseTracker.php");
 Bootstrap::registerClass('CaseTracker',         PATH_HOME . "engine/classes/model/CaseTracker.php");
 
 Bootstrap::registerClass('BaseCaseTrackerPeer', PATH_HOME . "engine/classes/model/om/BaseCaseTrackerPeer.php");
 Bootstrap::registerClass('CaseTrackerPeer',     PATH_HOME . "engine/classes/model/CaseTrackerPeer.php");
 
 Bootstrap::registerClass('BaseCaseTrackerObject',PATH_HOME . "engine/classes/model/om/BaseCaseTrackerObject.php");
 Bootstrap::registerClass('CaseTrackerObject',    PATH_HOME . "engine/classes/model/CaseTrackerObject.php");
 
 Bootstrap::registerClass('BaseCaseTrackerObjectPeer',PATH_HOME . "engine/classes/model/om/BaseCaseTrackerObjectPeer.php");
 Bootstrap::registerClass('CaseTrackerObjectPeer',    PATH_HOME . "engine/classes/model/CaseTrackerObjectPeer.php");
 
 Bootstrap::registerClass('BaseConfiguration',   PATH_HOME . "engine/classes/model/om/BaseConfiguration.php");
 Bootstrap::registerClass('Configuration',       PATH_HOME . "engine/classes/model/Configuration.php");
 
 Bootstrap::registerClass('BaseDbSource',        PATH_HOME . "engine/classes/model/om/BaseDbSource.php");
 Bootstrap::registerClass('DbSource',            PATH_HOME . "engine/classes/model/DbSource.php");
 
 Bootstrap::registerClass('XMLDB',              PATH_HOME . "engine/classes/class.xmlDb.php");
 Bootstrap::registerClass('dynaFormHandler',    PATH_GULLIVER . "class.dynaformhandler.php");
 Bootstrap::registerClass('DynaFormField',      PATH_HOME . "engine/classes/class.dynaFormField.php");
 Bootstrap::registerClass('BaseDynaform',       PATH_HOME . "engine/classes/model/om/BaseDynaform.php");
 Bootstrap::registerClass('Dynaform',           PATH_HOME . "engine/classes/model/Dynaform.php");
 Bootstrap::registerClass('DynaformPeer',       PATH_HOME . "engine/classes/model/DynaformPeer.php");
 
 Bootstrap::registerClass('BaseEvent',          PATH_HOME . "engine/classes/model/om/BaseEvent.php");
 Bootstrap::registerClass('Event',              PATH_HOME . "engine/classes/model/Event.php");
 
 Bootstrap::registerClass('BaseEventPeer',      PATH_HOME . "engine/classes/model/om/BaseEventPeer.php");
 Bootstrap::registerClass('EventPeer',          PATH_HOME . "engine/classes/model/EventPeer.php");
 
 Bootstrap::registerClass('BaseFields',         PATH_HOME . "engine/classes/model/om/BaseFields.php");
 Bootstrap::registerClass('Fields',             PATH_HOME . "engine/classes/model/Fields.php");
 
 Bootstrap::registerClass('BaseGateway',        PATH_HOME . "engine/classes/model/om/BaseGateway.php");
 Bootstrap::registerClass('Gateway',            PATH_HOME . "engine/classes/model/Gateway.php");
 
 Bootstrap::registerClass('BaseGroupUser',      PATH_HOME . "engine/classes/model/om/BaseGroupUser.php");
 Bootstrap::registerClass('Groupwf',            PATH_HOME . "engine/classes/model/Groupwf.php");
 Bootstrap::registerClass('GroupUser',          PATH_HOME . "engine/classes/model/GroupUser.php");
 
 Bootstrap::registerClass('BaseGroupUserPeer',  PATH_HOME . "engine/classes/model/om/BaseGroupUserPeer.php");
 Bootstrap::registerClass('GroupUserPeer',      PATH_HOME . "engine/classes/model/GroupUserPeer.php");
 
 Bootstrap::registerClass('BaseGroupwfPeer',    PATH_HOME . "engine/classes/model/om/BaseGroupwfPeer.php");
 Bootstrap::registerClass('GroupwfPeer',        PATH_HOME . "engine/classes/model/GroupwfPeer.php");
 
 Bootstrap::registerClass('BaseInputDocumentPeer',PATH_HOME . 'engine/classes/model/om/BaseInputDocumentPeer.php');
 Bootstrap::registerClass('InputDocumentPeer',  PATH_HOME . 'engine/classes/model/InputDocumentPeer.php');
 
 Bootstrap::registerClass('BaseIsoCountry',     PATH_HOME . "engine/classes/model/om/BaseIsoCountry.php");
 Bootstrap::registerClass('IsoCountry',         PATH_HOME . "engine/classes/model/IsoCountry.php");
 Bootstrap::registerClass('BaseTranslation',    PATH_HOME . "engine/classes/model/om/BaseTranslation.php");
 Bootstrap::registerClass('Translation',        PATH_HOME . "engine/classes/model/Translation.php");
 Bootstrap::registerClass('BaseLanguage',       PATH_HOME . "engine/classes/model/om/BaseLanguage.php");
 Bootstrap::registerClass('Language',           PATH_HOME . "engine/classes/model/Language.php");
 
 Bootstrap::registerClass('BaseLogCasesScheduler',PATH_HOME . "engine/classes/model/om/BaseLogCasesScheduler.php");
 Bootstrap::registerClass('LogCasesScheduler',  PATH_HOME . "engine/classes/model/LogCasesScheduler.php");
 
 Bootstrap::registerClass('BaseObjectPermission',PATH_HOME . "engine/classes/model/om/BaseObjectPermission.php");
 Bootstrap::registerClass('ObjectPermission',    PATH_HOME . "engine/classes/model/ObjectPermission.php");
 Bootstrap::registerClass('ObjectPermissionPeer',PATH_HOME . "engine/classes/model/ObjectPermissionPeer.php");
 
 Bootstrap::registerClass('BaseOutputDocument',  PATH_HOME . "engine/classes/model/om/BaseOutputDocument.php");
 Bootstrap::registerClass('OutputDocument',      PATH_HOME . "engine/classes/model/OutputDocument.php");
 Bootstrap::registerClass('OutputDocumentPeer',  PATH_HOME . "engine/classes/model/OutputDocumentPeer.php");
 
 Bootstrap::registerClass('BaseProcess',         PATH_HOME . "engine/classes/model/om/BaseProcess.php");
 Bootstrap::registerClass('BaseProcessCategory', PATH_HOME . "engine/classes/model/om/BaseProcessCategory.php");
 Bootstrap::registerClass('ProcessCategory',     PATH_HOME . "engine/classes/model/ProcessCategory.php");
 Bootstrap::registerClass('ProcessCategoryPeer', PATH_HOME . "engine/classes/model/ProcessCategoryPeer.php");
 Bootstrap::registerClass('ProcessPeer',         PATH_HOME . "engine/classes/model/ProcessPeer.php");
 Bootstrap::registerClass('Process',             PATH_HOME . "engine/classes/model/Process.php");
 
 Bootstrap::registerClass('BaseProcessUser',     PATH_HOME . "engine/classes/model/om/BaseProcessUser.php");
 Bootstrap::registerClass('ProcessUser',         PATH_HOME . "engine/classes/model/ProcessUser.php");
 
 Bootstrap::registerClass('BaseProcessUserPeer', PATH_HOME . "engine/classes/model/om/BaseProcessUserPeer.php");
 Bootstrap::registerClass('ProcessUserPeer',     PATH_HOME . "engine/classes/model/ProcessUserPeer.php");
 
 Bootstrap::registerClass('BaseReportTable',     PATH_HOME . "engine/classes/model/om/BaseReportTable.php");
 Bootstrap::registerClass('ReportTable',         PATH_HOME . "engine/classes/model/ReportTable.php");
 Bootstrap::registerClass('ReportTablePeer',     PATH_HOME . "engine/classes/model/ReportTablePeer.php");
 
 Bootstrap::registerClass('BaseReportVar',       PATH_HOME . "engine/classes/model/om/BaseReportVar.php");
 Bootstrap::registerClass('ReportVar',           PATH_HOME . "engine/classes/model/ReportVar.php");
 
 Bootstrap::registerClass('BaseReportVarPeer',   PATH_HOME . "engine/classes/model/om/BaseReportVarPeer.php");
 Bootstrap::registerClass('ReportVarPeer',       PATH_HOME . "engine/classes/model/ReportVarPeer.php");
 
 Bootstrap::registerClass('BaseRoute',           PATH_HOME . "engine/classes/model/om/BaseRoute.php");
 Bootstrap::registerClass('Route',               PATH_HOME . "engine/classes/model/Route.php");
 Bootstrap::registerClass('RoutePeer',           PATH_HOME . "engine/classes/model/RoutePeer.php");
 
 Bootstrap::registerClass('BaseStep',            PATH_HOME . "engine/classes/model/om/BaseStep.php");
 Bootstrap::registerClass('Step',                PATH_HOME . "engine/classes/model/Step.php");
 Bootstrap::registerClass('StepPeer',            PATH_HOME . "engine/classes/model/StepPeer.php");
 
 Bootstrap::registerClass('BaseStepSupervisor',  PATH_HOME . "engine/classes/model/om/BaseStepSupervisor.php");
 Bootstrap::registerClass('StepSupervisor',      PATH_HOME . "engine/classes/model/StepSupervisor.php");
 
 Bootstrap::registerClass('BaseStepSupervisorPeer',PATH_HOME . "engine/classes/model/om/BaseStepSupervisorPeer.php");
 Bootstrap::registerClass('StepSupervisorPeer',  PATH_HOME . "engine/classes/model/StepSupervisorPeer.php");
 
 Bootstrap::registerClass('BaseStepTrigger',     PATH_HOME . "engine/classes/model/om/BaseStepTrigger.php");
 Bootstrap::registerClass('StepTrigger',         PATH_HOME . "engine/classes/model/StepTrigger.php");
 Bootstrap::registerClass('StepTriggerPeer',     PATH_HOME . "engine/classes/model/StepTriggerPeer.php");
 
 Bootstrap::registerClass('SolrRequestData',     PATH_HOME . "engine/classes/entities/SolrRequestData.php");
 
 Bootstrap::registerClass('SolrUpdateDocument',  PATH_HOME . "engine/classes/entities/SolrUpdateDocument.php");
 
 Bootstrap::registerClass('BaseSwimlanesElements',PATH_HOME . "engine/classes/model/om/BaseSwimlanesElements.php");
 Bootstrap::registerClass('SwimlanesElements',   PATH_HOME . "engine/classes/model/SwimlanesElements.php");
 Bootstrap::registerClass('BaseSwimlanesElementsPeer',PATH_HOME ."engine/classes/model/om/BaseSwimlanesElementsPeer.php");
 Bootstrap::registerClass('SwimlanesElementsPeer',PATH_HOME . "engine/classes/model/SwimlanesElementsPeer.php");
 
 Bootstrap::registerClass('BaseSubApplication',  PATH_HOME . "engine/classes/model/om/BaseSubApplication.php");
 Bootstrap::registerClass('SubApplication',      PATH_HOME . "engine/classes/model/SubApplication.php");
 Bootstrap::registerClass('SubApplicationPeer',  PATH_HOME . "engine/classes/model/SubApplicationPeer.php");
 
 Bootstrap::registerClass('BaseSubProcess',      PATH_HOME . "engine/classes/model/om/BaseSubProcess.php");
 Bootstrap::registerClass('SubProcess',          PATH_HOME . "engine/classes/model/SubProcess.php");
 
 Bootstrap::registerClass('BaseSubProcessPeer',  PATH_HOME . "engine/classes/model/om/BaseSubProcessPeer.php");
 Bootstrap::registerClass('SubProcessPeer',      PATH_HOME . "engine/classes/model/SubProcessPeer.php");
 
 Bootstrap::registerClass('BaseTask',            PATH_HOME . "engine/classes/model/om/BaseTask.php");
 Bootstrap::registerClass('Task',                PATH_HOME . "engine/classes/model/Task.php");
 
 Bootstrap::registerClass('BaseTaskUser',        PATH_HOME . "engine/classes/model/om/BaseTaskUser.php");
 Bootstrap::registerClass('TaskUserPeer',        PATH_HOME . "engine/classes/model/TaskUserPeer.php");
 Bootstrap::registerClass('TaskUser',            PATH_HOME . "engine/classes/model/TaskUser.php");
 
 Bootstrap::registerClass('BaseTriggers',        PATH_HOME . "engine/classes/model/om/BaseTriggers.php");
 Bootstrap::registerClass('Triggers',            PATH_HOME . "engine/classes/model/Triggers.php");
 Bootstrap::registerClass('BaseTriggersPeer',    PATH_HOME . "engine/classes/model/om/BaseTriggersPeer.php");
 Bootstrap::registerClass('TriggersPeer',        PATH_HOME . "engine/classes/model/TriggersPeer.php");
 
 Bootstrap::registerClass('BaseUsers',           PATH_HOME . "engine/classes/model/om/BaseUsers.php");
 Bootstrap::registerClass('IsoCountry',          PATH_HOME . "engine/classes/model/IsoCountry.php");
 Bootstrap::registerClass('BaseIsoSubdivision',  PATH_HOME . "engine/classes/model/om/BaseIsoSubdivision.php");
 Bootstrap::registerClass('IsoSubdivision',      PATH_HOME . "engine/classes/model/IsoSubdivision.php");
 Bootstrap::registerClass('BaseIsoLocation',     PATH_HOME . "engine/classes/model/om/BaseIsoLocation.php");
 Bootstrap::registerClass('IsoLocation',         PATH_HOME . "engine/classes/model/IsoLocation.php");
 Bootstrap::registerClass('Users',               PATH_HOME . "engine/classes/model/Users.php");
 Bootstrap::registerClass('UsersPeer',           PATH_HOME . "engine/classes/model/UsersPeer.php");
 
 Bootstrap::registerClass('Xml_Node',            PATH_GULLIVER . "class.xmlDocument.php");
 
 Bootstrap::registerClass('wsResponse',          PATH_HOME . "engine/classes/class.wsResponse.php");
 
 Bootstrap::registerClass('PMLicensedFeatures',  PATH_HOME . "engine/classes/class.LicensedFeatures.php");
 Bootstrap::registerClass('AddonsManagerPeer',   PATH_HOME . "engine/classes/model/AddonsManagerPeer.php");
 
 G::LoadClass("dates");
 
 if (!defined('SYS_SYS')) {
     $sObject = $argv[1];
     $sNow    = $argv[2];
     $dateSystem = $argv[3];
     $sFilter = '';
 
     for ($i = 4; $i <= count($argv) - 1; $i++) {
         $sFilter .= ' ' . $argv[$i];
     }
 
     $oDirectory = dir(PATH_DB);
 
     if (is_dir(PATH_DB . $sObject)) {
         saveLog('main', 'action', "checking folder " . PATH_DB . $sObject);
 
         if (file_exists(PATH_DB . $sObject . PATH_SEP . 'db.php')) {
             define('SYS_SYS', $sObject);
 
             include_once (PATH_HOME . 'engine' . PATH_SEP . 'config' . PATH_SEP . 'paths_installed.php');
             include_once (PATH_HOME . 'engine' . PATH_SEP . 'config' . PATH_SEP . 'paths.php');
 
             //***************** PM Paths DATA **************************
             define('PATH_DATA_SITE',                PATH_DATA      . 'sites/' . SYS_SYS . '/');
             define('PATH_DOCUMENT',                 PATH_DATA_SITE . 'files/');
             define('PATH_DATA_MAILTEMPLATES',       PATH_DATA_SITE . 'mailTemplates/');
             define('PATH_DATA_PUBLIC',              PATH_DATA_SITE . 'public/');
             define('PATH_DATA_REPORTS',             PATH_DATA_SITE . 'reports/');
             define('PATH_DYNAFORM',                 PATH_DATA_SITE . 'xmlForms/');
             define('PATH_IMAGES_ENVIRONMENT_FILES', PATH_DATA_SITE . 'usersFiles' . PATH_SEP);
             define('PATH_IMAGES_ENVIRONMENT_USERS', PATH_DATA_SITE . 'usersPhotographies' . PATH_SEP);
 
             if (is_file(PATH_DATA_SITE.PATH_SEP . '.server_info')) {
                 $SERVER_INFO = file_get_contents(PATH_DATA_SITE.PATH_SEP.'.server_info');
                 $SERVER_INFO = unserialize($SERVER_INFO);
 
                 define('SERVER_NAME', $SERVER_INFO ['SERVER_NAME']);
                 define('SERVER_PORT', $SERVER_INFO ['SERVER_PORT']);
             } else {
                 eprintln("WARNING! No server info found!", 'red');
             }
 
             $sContent = file_get_contents(PATH_DB . $sObject . PATH_SEP . 'db.php');
 
             $sContent = str_replace('<?php', '', $sContent);
             $sContent = str_replace('<?', '', $sContent);
             $sContent = str_replace('?>', '', $sContent);
             $sContent = str_replace('define', '', $sContent);
             $sContent = str_replace("('", "$", $sContent);
             $sContent = str_replace("',", '=', $sContent);
             $sContent = str_replace(");", ';', $sContent);
 
             eval($sContent);
 
             $dsn = $DB_ADAPTER . '://' . $DB_USER . ':' . $DB_PASS . '@' . $DB_HOST . '/' . $DB_NAME;
 
             $dsnRbac = $DB_ADAPTER . '://' . $DB_RBAC_USER . ':' . $DB_RBAC_PASS . '@' . $DB_RBAC_HOST . '/';
             $dsnRbac = $dsnRbac . $DB_RBAC_NAME;
 
             $dsnRp = $DB_ADAPTER . '://' . $DB_REPORT_USER . ':' . $DB_REPORT_PASS . '@' . $DB_REPORT_HOST . '/';
             $dsnRp = $dsnRp . $DB_REPORT_NAME;
 
             switch ($DB_ADAPTER) {
                 case 'mysql':
                     $dsn .= '?encoding=utf8';
                     $dsnRbac .= '?encoding=utf8';
                     break;
                 case 'mssql':
                     //$dsn .= '?sendStringAsUnicode=false';
                     //$dsnRbac .= '?sendStringAsUnicode=false';
                     break;
                 default:
                     break;
             }
 
             $pro['datasources']['workflow']['connection'] = $dsn;
             $pro['datasources']['workflow']['adapter'] = $DB_ADAPTER;
             $pro['datasources']['rbac']['connection'] = $dsnRbac;
             $pro['datasources']['rbac']['adapter'] = $DB_ADAPTER;
             $pro['datasources']['rp']['connection'] = $dsnRp;
             $pro['datasources']['rp']['adapter'] = $DB_ADAPTER;
             //$pro['datasources']['dbarray']['connection'] = 'dbarray://user:pass@localhost/pm_os';
             //$pro['datasources']['dbarray']['adapter']    = 'dbarray';
 
             $oFile = fopen(PATH_CORE . 'config/_databases_.php', 'w');
             fwrite($oFile, '<?php global $pro;return $pro; ?>');
             fclose($oFile);
 
             Propel::init(PATH_CORE . 'config/_databases_.php');
             //Creole::registerDriver('dbarray', 'creole.contrib.DBArrayConnection');
 
             // enable rbac
             Bootstrap::LoadSystem( 'rbac' );
             $RBAC = &RBAC::getSingleton( PATH_DATA, session_id() );
             $RBAC->sSystem = 'PROCESSMAKER';
 
             eprintln("Processing workspace: " . $sObject, "green");
 
             try {
                 processWorkspace();
             } catch (Exception $e) {
                 echo $e->getMessage();
 
                 eprintln("Probelm in workspace: " . $sObject . " it was omitted.", "red");
             }
 
             eprintln();
         }
     }
 
     unlink(PATH_CORE . 'config/_databases_.php');
 } else {
     processWorkspace();
 }
 
 
 
 
 
 function processWorkspace()
 {
     try {
         Bootstrap::LoadClass("plugin");
         $oPluginRegistry =& PMPluginRegistry::getSingleton();
         if (file_exists(PATH_DATA_SITE . 'plugin.singleton')) {
             $oPluginRegistry->unSerializeInstance(file_get_contents(PATH_DATA_SITE . 'plugin.singleton'));
         }
         Bootstrap::LoadClass("case");
 
         global $sObject;
         global $sLastExecution;
 
         resendEmails();
         unpauseApplications();
         calculateDuration();
         executeEvents($sLastExecution);
         executeScheduledCases();
         executeUpdateAppTitle();
         executeCaseSelfService();
         executePlugins();
     } catch (Exception $oError) {
         saveLog("main", "error", "Error processing workspace : " . $oError->getMessage() . "\n");
     }
 }
 
 function resendEmails()
 {
     global $sFilter;
     global $sNow;
     global $dateSystem;
 
     if ($sFilter != "" && strpos($sFilter, "emails") === false) {
         return false;
     }
 
     setExecutionMessage("Resending emails");
 
     try {
         G::LoadClass("spool");
 
         $dateResend = $sNow;
 
         if ($sNow == $dateSystem) {
             $arrayDateSystem = getdate(strtotime($dateSystem));
 
             $mktDateSystem = mktime(
                 $arrayDateSystem["hours"],
                 $arrayDateSystem["minutes"],
                 $arrayDateSystem["seconds"],
                 $arrayDateSystem["mon"],
                 $arrayDateSystem["mday"],
                 $arrayDateSystem["year"]
             );
 
             $dateResend = date("Y-m-d H:i:s", $mktDateSystem - (7 * 24 * 60 * 60));
         }
 
         $oSpool = new spoolRun();
         $oSpool->resendEmails($dateResend, 1);
 
         saveLog("resendEmails", "action", "Resending Emails", "c");
 
         $aSpoolWarnings = $oSpool->getWarnings();
 
         if ($aSpoolWarnings !== false) {
             foreach ($aSpoolWarnings as $sWarning) {
                 print("MAIL SPOOL WARNING: " . $sWarning."\n");
                 saveLog("resendEmails", "warning", "MAIL SPOOL WARNING: " . $sWarning);
             }
         }
 
         setExecutionResultMessage("DONE");
     } catch (Exception $e) {
         setExecutionResultMessage("WITH ERRORS", "error");
         eprintln("  '-" . $e->getMessage(), "red");
         saveLog("resendEmails", "error", "Error Resending Emails: " . $e->getMessage());
     }
 }
 
 function unpauseApplications()
 {
     global $sFilter;
     global $sNow;
 
     if ($sFilter != '' && strpos($sFilter, 'unpause') === false) {
         return false;
     }
 
     setExecutionMessage("Unpausing applications");
 
     try {
         G::LoadClass('case');
 
         $oCases = new Cases();
         $oCases->ThrowUnpauseDaemon($sNow, 1);
 
         setExecutionResultMessage('DONE');
         saveLog('unpauseApplications', 'action', 'Unpausing Applications');
     } catch (Exception $oError) {
         setExecutionResultMessage('WITH ERRORS', 'error');
         eprintln("  '-".$oError->getMessage(), 'red');
         saveLog('unpauseApplications', 'error', 'Error Unpausing Applications: ' . $oError->getMessage());
     }
 }
 
 function executePlugins()
 {
     global $sFilter;
 
     if ($sFilter != '' && strpos($sFilter, 'plugins') === false) {
         return false;
     }
 
     $pathCronPlugins = PATH_CORE . 'bin' . PATH_SEP . 'plugins' . PATH_SEP;
 
     // Executing cron files in bin/plugins directory
     if (!is_dir($pathCronPlugins)) {
         return false;
     }
 
     if ($handle = opendir($pathCronPlugins)) {
         setExecutionMessage('Executing cron files in bin/plugins directory in Workspace: ' . SYS_SYS);
         while (false !== ($file = readdir($handle))) {
             if (strpos($file, '.php',1) && is_file($pathCronPlugins . $file)) {
                 $filename  = str_replace('.php' , '', $file);
                 $className = $filename . 'ClassCron';
 
                 // Execute custom cron function
                 executeCustomCronFunction($pathCronPlugins . $file, $className);
             }
         }
     }
 
     // Executing registered cron files
 
     // -> Get registered cron files
     $oPluginRegistry =& PMPluginRegistry::getSingleton();
     $cronFiles = $oPluginRegistry->getCronFiles();
 
     // -> Execute functions
     if (!empty($cronFiles)) {
         setExecutionMessage('Executing registered cron files for Workspace: ' . SYS_SYS);
         foreach($cronFiles as $cronFile) {
             executeCustomCronFunction(PATH_PLUGINS . $cronFile->namespace . PATH_SEP . 'bin' . PATH_SEP . $cronFile->cronFile . '.php', $cronFile->cronFile);
         }
     }
 
 }
 function executeCustomCronFunction($pathFile, $className)
 {
     include_once $pathFile;
 
     $oPlugin = new $className();
 
     if (method_exists($oPlugin, 'executeCron')) {
         $arrayCron = unserialize(trim(@file_get_contents(PATH_DATA . "cron")));
         $arrayCron["processcTimeProcess"] = 60; //Minutes
         $arrayCron["processcTimeStart"]   = time();
         @file_put_contents(PATH_DATA . "cron", serialize($arrayCron));
 
         //Try to execute Plugin Cron. If there is an error then continue with the next file
         setExecutionMessage("\n--- Executing cron file: $pathFile");
         try {
             $oPlugin->executeCron();
             setExecutionResultMessage('DONE');
         } catch (Exception $e) {
             setExecutionResultMessage('FAILED', 'error');
             eprintln("  '-".$e->getMessage(), 'red');
             saveLog('executePlugins', 'error', 'Error executing cron file: ' . $pathFile . ' - ' . $e->getMessage());
         }
     }
 }
 
 function calculateDuration()
 {
     global $sFilter;
 
     if ($sFilter != '' && strpos($sFilter, 'calculate') === false) {
         return false;
     }
 
     setExecutionMessage("Calculating Duration");
 
     try {
         $oAppDelegation = new AppDelegation();
         $oAppDelegation->calculateDuration(1);
 
         setExecutionResultMessage('DONE');
         saveLog('calculateDuration', 'action', 'Calculating Duration');
     } catch (Exception $oError) {
         setExecutionResultMessage('WITH ERRORS', 'error');
         eprintln("  '-".$oError->getMessage(), 'red');
         saveLog('calculateDuration', 'error', 'Error Calculating Duration: ' . $oError->getMessage());
     }
 }
 
 function executeEvents($sLastExecution, $sNow=null)
 {
     global $sFilter;
     global $sNow;
 
     $log = array();
 
     if ($sFilter != '' && strpos($sFilter, 'events') === false) {
         return false;
     }
 
     setExecutionMessage("Executing events");
     setExecutionResultMessage('PROCESSING');
 
     try {
         $oAppEvent = new AppEvent();
         saveLog('executeEvents', 'action', "Executing Events $sLastExecution, $sNow ");
         $n = $oAppEvent->executeEvents($sNow, false, $log, 1);
 
         foreach ($log as $value) {
             $arrayCron = unserialize(trim(@file_get_contents(PATH_DATA . "cron")));
             $arrayCron["processcTimeStart"] = time();
             @file_put_contents(PATH_DATA . "cron", serialize($arrayCron));
 
             saveLog('executeEvents', 'action', "Execute Events : $value, $sNow ");
         }
 
         setExecutionMessage("|- End Execution events");
         setExecutionResultMessage("Processed $n");
         //saveLog('executeEvents', 'action', $res );
     } catch (Exception $oError) {
         setExecutionResultMessage('WITH ERRORS', 'error');
         eprintln("  '-".$oError->getMessage(), 'red');
         saveLog('calculateAlertsDueDate', 'Error', 'Error Executing Events: ' . $oError->getMessage());
     }
 }
 
 function executeScheduledCases($sNow=null)
 {
     try {
         global $sFilter;
         global $sNow;
 
         $log = array();
 
         if ($sFilter != '' && strpos($sFilter, 'scheduler') === false) {
             return false;
         }
 
         setExecutionMessage("Executing the scheduled starting cases");
         setExecutionResultMessage('PROCESSING');
 
         $sNow = isset($sNow)? $sNow : date('Y-m-d H:i:s');
 
         $oCaseScheduler = new CaseScheduler();
         $oCaseScheduler->caseSchedulerCron($sNow, $log, 1);
 
         foreach ($log as $value) {
             $arrayCron = unserialize(trim(@file_get_contents(PATH_DATA . "cron")));
             $arrayCron["processcTimeStart"] = time();
             @file_put_contents(PATH_DATA . "cron", serialize($arrayCron));
 
             saveLog('executeScheduledCases', 'action', "OK Case# $value");
         }
 
         setExecutionResultMessage('DONE');
     } catch (Exception $oError) {
         setExecutionResultMessage('WITH ERRORS', 'error');
         eprintln("  '-".$oError->getMessage(), 'red');
     }
 }
 
 function executeUpdateAppTitle()
 {
     try {
         global $sFilter;
 
         if ($sFilter != "" && strpos($sFilter, "update-case-labels") === false) {
             return false;
         }
 
         $criteriaConf = new Criteria("workflow");
 
         $criteriaConf->addSelectColumn(ConfigurationPeer::OBJ_UID);
         $criteriaConf->addSelectColumn(ConfigurationPeer::CFG_VALUE);
         $criteriaConf->add(ConfigurationPeer::CFG_UID, "TAS_APP_TITLE_UPDATE");
 
         $rsCriteriaConf = ConfigurationPeer::doSelectRS($criteriaConf);
         $rsCriteriaConf->setFetchmode(ResultSet::FETCHMODE_ASSOC);
 
         setExecutionMessage("Update case labels");
         saveLog("updateCaseLabels", "action", "Update case labels", "c");
 
         while ($rsCriteriaConf->next()) {
             $row = $rsCriteriaConf->getRow();
 
             $taskUid = $row["OBJ_UID"];
             $lang    = $row["CFG_VALUE"];
 
             //Update case labels
             $appcv = new AppCacheView();
             $appcv->appTitleByTaskCaseLabelUpdate($taskUid, $lang, 1);
 
             //Delete record
             $criteria = new Criteria("workflow");
 
             $criteria->add(ConfigurationPeer::CFG_UID, "TAS_APP_TITLE_UPDATE");
             $criteria->add(ConfigurationPeer::OBJ_UID, $taskUid);
             $criteria->add(ConfigurationPeer::CFG_VALUE, $lang);
 
             $numRowDeleted = ConfigurationPeer::doDelete($criteria);
 
             saveLog("updateCaseLabels", "action", "OK Task $taskUid");
         }
 
         setExecutionResultMessage("DONE");
     } catch (Exception $e) {
         setExecutionResultMessage("WITH ERRORS", "error");
         eprintln("  '-" . $e->getMessage(), "red");
         saveLog("updateCaseLabels", "error", "Error updating case labels: " . $e->getMessage());
     }
 }
 
 function executeCaseSelfService()
 {
     try {
         global $sFilter;
 
         if ($sFilter != "" && strpos($sFilter, "unassigned-case") === false) {
             return false;
         }
 
         $criteria = new Criteria("workflow");
 
         //SELECT
         $criteria->addSelectColumn(AppCacheViewPeer::APP_UID);
         $criteria->addSelectColumn(AppCacheViewPeer::DEL_INDEX);
         $criteria->addSelectColumn(AppCacheViewPeer::DEL_DELEGATE_DATE);
         $criteria->addSelectColumn(AppCacheViewPeer::APP_NUMBER);
         $criteria->addSelectColumn(AppCacheViewPeer::PRO_UID);
         $criteria->addSelectColumn(TaskPeer::TAS_UID);
         $criteria->addSelectColumn(TaskPeer::TAS_SELFSERVICE_TIME);
         $criteria->addSelectColumn(TaskPeer::TAS_SELFSERVICE_TIME_UNIT);
         $criteria->addSelectColumn(TaskPeer::TAS_SELFSERVICE_TRIGGER_UID);
         /*----------------------------------********---------------------------------*/
 
         //FROM
         $condition = array();
         $condition[] = array(AppCacheViewPeer::TAS_UID, TaskPeer::TAS_UID);
         $condition[] = array(TaskPeer::TAS_SELFSERVICE_TIMEOUT, 1);
         $criteria->addJoinMC($condition, Criteria::LEFT_JOIN);
 
         //WHERE
         $criteria->add(AppCacheViewPeer::USR_UID, "");
         $criteria->add(AppCacheViewPeer::DEL_THREAD_STATUS, "OPEN");
 
         //QUERY
         $rsCriteria = AppCacheViewPeer::doSelectRS($criteria);
         $rsCriteria->setFetchmode(ResultSet::FETCHMODE_ASSOC);
 
         setExecutionMessage("Unassigned case");
         saveLog("unassignedCase", "action", "Unassigned case", "c");
 
         $calendar = new calendar();
 
         while ($rsCriteria->next()) {
 
             $row = $rsCriteria->getRow();
 			$flag = false;
 
             $appcacheAppUid   = $row["APP_UID"];
             $appcacheDelIndex = $row["DEL_INDEX"];
             $appcacheDelDelegateDate = $row["DEL_DELEGATE_DATE"];
             $appcacheAppNumber = $row["APP_NUMBER"];
             $appcacheProUid    = $row["PRO_UID"];
             $taskUid = $row["TAS_UID"];
             $taskSelfServiceTime = intval($row["TAS_SELFSERVICE_TIME"]);
             $taskSelfServiceTimeUnit = $row["TAS_SELFSERVICE_TIME_UNIT"];
             $taskSelfServiceTriggerUid = $row["TAS_SELFSERVICE_TRIGGER_UID"];
             /*----------------------------------********---------------------------------*/
 
             if ($calendar->pmCalendarUid == '') {
             	$calendar->getCalendar(null, $appcacheProUid, $taskUid);
             	$calendar->getCalendarData();
             }
 
             $dueDate = $calendar->calculateDate(
                 $appcacheDelDelegateDate,
                 $taskSelfServiceTime,
                 $taskSelfServiceTimeUnit //HOURS|DAYS
                 //1
             );
 
             if (time() > $dueDate["DUE_DATE_SECONDS"] && $flag == false) {
                 $sessProcess = null;
                 $sessProcessSw = 0;
 
                 //Load data
                 $case = new Cases();
                 $appFields = $case->loadCase($appcacheAppUid);
 
                 $appFields["APP_DATA"]["APPLICATION"] = $appcacheAppUid;
 
                 if (isset($_SESSION["PROCESS"])) {
                     $sessProcess = $_SESSION["PROCESS"];
                     $sessProcessSw = 1;
                 }
 
                 $_SESSION["PROCESS"] = $appFields["PRO_UID"];
 
                 //Execute trigger
                 $criteriaTgr = new Criteria();
                 $criteriaTgr->add(TriggersPeer::TRI_UID, $taskSelfServiceTriggerUid);
 
                 $rsCriteriaTgr = TriggersPeer::doSelectRS($criteriaTgr);
                 $rsCriteriaTgr->setFetchmode(ResultSet::FETCHMODE_ASSOC);
 
                 if ($rsCriteriaTgr->next()) {
                     $row = $rsCriteriaTgr->getRow();
 
                     if (is_array($row) && $row["TRI_TYPE"] == "SCRIPT") {
 
                         $arrayCron = unserialize(trim(@file_get_contents(PATH_DATA . "cron")));
                         $arrayCron["processcTimeProcess"] = 60; //Minutes
                         $arrayCron["processcTimeStart"]   = time();
                         @file_put_contents(PATH_DATA . "cron", serialize($arrayCron));
 
                         //Trigger
                         global $oPMScript;
 
                         $oPMScript = new PMScript();
                         $oPMScript->setFields($appFields["APP_DATA"]);
                         $oPMScript->setScript($row["TRI_WEBBOT"]);
                         $oPMScript->execute();
 
                         /*----------------------------------********---------------------------------*/
 
                         $appFields["APP_DATA"] = array_merge($appFields["APP_DATA"], $oPMScript->aFields);
 
                         unset($appFields['APP_STATUS']);
                         unset($appFields['APP_PROC_STATUS']);
                         unset($appFields['APP_PROC_CODE']);
                         unset($appFields['APP_PIN']);
                         $case->updateCase($appFields["APP_UID"], $appFields);
 
                         saveLog("unassignedCase", "action", "OK Executed tigger to the case $appcacheAppNumber");
                     }
                 }
 
                 unset($_SESSION["PROCESS"]);
 
                 if ($sessProcessSw == 1) {
                     $_SESSION["PROCESS"] = $sessProcess;
                 }
             }
         }
 
         setExecutionResultMessage("DONE");
     } catch (Exception $e) {
         setExecutionResultMessage("WITH ERRORS", "error");
         eprintln("  '-" . $e->getMessage(), "red");
         saveLog("unassignedCase", "error", "Error in unassigned case: " . $e->getMessage());
     }
 }
 
 function saveLog($sSource, $sType, $sDescription)
 {
     try {
         global $sObject;
         global $isDebug;
 
         if ($isDebug) {
             print date("H:i:s") . " ($sSource) $sType $sDescription <br />\n";
         }
 
         G::verifyPath(PATH_DATA . "log" . PATH_SEP, true);
         G::log("| $sObject | " . $sSource . " | $sType | " . $sDescription, PATH_DATA);
     } catch (Exception $e) {
         //CONTINUE
     }
 }
 
 function setExecutionMessage($m)
 {
     $len      = strlen($m);
     $linesize = 60;
     $rOffset  = $linesize - $len;
 
     eprint("* $m");
 
     for ($i = 0; $i < $rOffset; $i++) {
         eprint('.');
     }
 }
 
 function setExecutionResultMessage($m, $t='')
 {
     $c = 'green';
 
     if ($t == 'error') {
         $c = 'red';
     }
 
     if ($t == 'info') {
         $c = 'yellow';
     }
 
     eprintln("[$m]", $c);
 }
 
