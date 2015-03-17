<?php

require_once 'propel/map/MapBuilder.php';
include_once 'creole/CreoleTypes.php';


/**
 * This class adds structure of 'APP_CACHE_VIEW' table to 'workflow' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    workflow.classes.model.map
 */
class AppCacheViewMapBuilder
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'classes.model.map.AppCacheViewMapBuilder';

    /**
     * The database map.
     */
    private $dbMap;

    /**
     * Tells us if this DatabaseMapBuilder is built so that we
     * don't have to re-build it every time.
     *
     * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
     */
    public function isBuilt()
    {
        return ($this->dbMap !== null);
    }

    /**
     * Gets the databasemap this map builder built.
     *
     * @return     the databasemap
     */
    public function getDatabaseMap()
    {
        return $this->dbMap;
    }

    /**
     * The doBuild() method builds the DatabaseMap
     *
     * @return     void
     * @throws     PropelException
     */
    public function doBuild()
    {
        $this->dbMap = Propel::getDatabaseMap('workflow');

        $tMap = $this->dbMap->addTable('APP_CACHE_VIEW');
        $tMap->setPhpName('AppCacheView');

        $tMap->setUseIdGenerator(false);

        $tMap->addPrimaryKey('APP_UID', 'AppUid', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addPrimaryKey('DEL_INDEX', 'DelIndex', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('DEL_LAST_INDEX', 'DelLastIndex', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('APP_NUMBER', 'AppNumber', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('APP_STATUS', 'AppStatus', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addColumn('USR_UID', 'UsrUid', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addColumn('PREVIOUS_USR_UID', 'PreviousUsrUid', 'string', CreoleTypes::VARCHAR, false, 32);

        $tMap->addColumn('TAS_UID', 'TasUid', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addColumn('PRO_UID', 'ProUid', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addColumn('DEL_DELEGATE_DATE', 'DelDelegateDate', 'int', CreoleTypes::TIMESTAMP, true, null);

        $tMap->addColumn('DEL_INIT_DATE', 'DelInitDate', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('DEL_TASK_DUE_DATE', 'DelTaskDueDate', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('DEL_FINISH_DATE', 'DelFinishDate', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('DEL_THREAD_STATUS', 'DelThreadStatus', 'string', CreoleTypes::VARCHAR, false, 32);

        $tMap->addColumn('APP_THREAD_STATUS', 'AppThreadStatus', 'string', CreoleTypes::VARCHAR, false, 32);

        $tMap->addColumn('APP_TITLE', 'AppTitle', 'string', CreoleTypes::VARCHAR, true, 255);

        $tMap->addColumn('APP_PRO_TITLE', 'AppProTitle', 'string', CreoleTypes::VARCHAR, true, 255);

        $tMap->addColumn('APP_TAS_TITLE', 'AppTasTitle', 'string', CreoleTypes::VARCHAR, true, 255);

        $tMap->addColumn('APP_CURRENT_USER', 'AppCurrentUser', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('APP_DEL_PREVIOUS_USER', 'AppDelPreviousUser', 'string', CreoleTypes::VARCHAR, false, 128);

        $tMap->addColumn('DEL_PRIORITY', 'DelPriority', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addColumn('DEL_DURATION', 'DelDuration', 'double', CreoleTypes::DOUBLE, false, null);

        $tMap->addColumn('DEL_QUEUE_DURATION', 'DelQueueDuration', 'double', CreoleTypes::DOUBLE, false, null);

        $tMap->addColumn('DEL_DELAY_DURATION', 'DelDelayDuration', 'double', CreoleTypes::DOUBLE, false, null);

        $tMap->addColumn('DEL_STARTED', 'DelStarted', 'int', CreoleTypes::TINYINT, true, null);

        $tMap->addColumn('DEL_FINISHED', 'DelFinished', 'int', CreoleTypes::TINYINT, true, null);

        $tMap->addColumn('DEL_DELAYED', 'DelDelayed', 'int', CreoleTypes::TINYINT, true, null);

        $tMap->addColumn('APP_CREATE_DATE', 'AppCreateDate', 'int', CreoleTypes::TIMESTAMP, true, null);

        $tMap->addColumn('APP_FINISH_DATE', 'AppFinishDate', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('APP_UPDATE_DATE', 'AppUpdateDate', 'int', CreoleTypes::TIMESTAMP, true, null);

        $tMap->addColumn('APP_OVERDUE_PERCENTAGE', 'AppOverduePercentage', 'double', CreoleTypes::DOUBLE, true, null);

    } // doBuild()

} // AppCacheViewMapBuilder
