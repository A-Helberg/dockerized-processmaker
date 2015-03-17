<?php

require_once 'propel/map/MapBuilder.php';
include_once 'creole/CreoleTypes.php';


/**
 * This class adds structure of 'RBAC_USERS' table to 'rbac' DatabaseMap object.
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
class RbacUsersMapBuilder
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'classes.model.map.RbacUsersMapBuilder';

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
        $this->dbMap = Propel::getDatabaseMap('rbac');

        $tMap = $this->dbMap->addTable('RBAC_USERS');
        $tMap->setPhpName('RbacUsers');

        $tMap->setUseIdGenerator(false);

        $tMap->addPrimaryKey('USR_UID', 'UsrUid', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addColumn('USR_USERNAME', 'UsrUsername', 'string', CreoleTypes::VARCHAR, true, 100);

        $tMap->addColumn('USR_PASSWORD', 'UsrPassword', 'string', CreoleTypes::VARCHAR, true, 128);

        $tMap->addColumn('USR_FIRSTNAME', 'UsrFirstname', 'string', CreoleTypes::VARCHAR, true, 50);

        $tMap->addColumn('USR_LASTNAME', 'UsrLastname', 'string', CreoleTypes::VARCHAR, true, 50);

        $tMap->addColumn('USR_EMAIL', 'UsrEmail', 'string', CreoleTypes::VARCHAR, true, 100);

        $tMap->addColumn('USR_DUE_DATE', 'UsrDueDate', 'int', CreoleTypes::DATE, true, null);

        $tMap->addColumn('USR_CREATE_DATE', 'UsrCreateDate', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('USR_UPDATE_DATE', 'UsrUpdateDate', 'int', CreoleTypes::TIMESTAMP, false, null);

        $tMap->addColumn('USR_STATUS', 'UsrStatus', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('USR_AUTH_TYPE', 'UsrAuthType', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addColumn('UID_AUTH_SOURCE', 'UidAuthSource', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addColumn('USR_AUTH_USER_DN', 'UsrAuthUserDn', 'string', CreoleTypes::VARCHAR, true, 255);

        $tMap->addColumn('USR_AUTH_SUPERVISOR_DN', 'UsrAuthSupervisorDn', 'string', CreoleTypes::VARCHAR, true, 255);

    } // doBuild()

} // RbacUsersMapBuilder
