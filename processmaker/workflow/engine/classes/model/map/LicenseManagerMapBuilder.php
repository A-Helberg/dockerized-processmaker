<?php

require_once 'propel/map/MapBuilder.php';
include_once 'creole/CreoleTypes.php';


/**
 * This class adds structure of 'LICENSE_MANAGER' table to 'workflow' DatabaseMap object.
 *
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    classes.model.map
 */
class LicenseManagerMapBuilder
{
    /**
     * The (dot-path) name of this class
    */
    const CLASS_NAME = 'classes.model.map.LicenseManagerMapBuilder';
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

        $tMap = $this->dbMap->addTable('LICENSE_MANAGER');

        $tMap->setPhpName('LicenseManager');

        $tMap->setUseIdGenerator(false);

        $tMap->addPrimaryKey('LICENSE_UID', 'LicenseUid', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addColumn('LICENSE_USER', 'LicenseUser', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addColumn('LICENSE_START', 'LicenseStart', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('LICENSE_END', 'LicenseEnd', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('LICENSE_SPAN', 'LicenseSpan', 'int', CreoleTypes::INTEGER, true, null);

        $tMap->addColumn('LICENSE_STATUS', 'LicenseStatus', 'string', CreoleTypes::VARCHAR, false, 100);

        $tMap->addColumn('LICENSE_DATA', 'LicenseData', 'string', CreoleTypes::LONGVARCHAR, true, null);

        $tMap->addColumn('LICENSE_PATH', 'LicensePath', 'string', CreoleTypes::VARCHAR, true, 255);

        $tMap->addColumn('LICENSE_WORKSPACE', 'LicenseWorkspace', 'string', CreoleTypes::VARCHAR, true, 32);

        $tMap->addColumn('LICENSE_TYPE', 'LicenseType', 'string', CreoleTypes::VARCHAR, true, 32);
    }
}

