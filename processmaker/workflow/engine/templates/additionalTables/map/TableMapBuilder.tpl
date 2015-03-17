<?php

require_once PATH_THIRDPARTY . 'propel/map/MapBuilder.php';
include_once PATH_THIRDPARTY . 'creole/CreoleTypes.php';


/**
 * This class adds structure of '{tableName}' table to '{connection}' DatabaseMap object.
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
class {className}MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'classes.model.map.{className}MapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap('{connection}');

		$tMap = $this->dbMap->addTable('{tableName}');

		$tMap->setPhpName('{className}');

		$tMap->setUseIdGenerator({useIdGenerator});

<!-- START BLOCK : primaryKeys -->
		$tMap->addPrimaryKey('{name}', '{phpName}', '{type}', CreoleTypes::{creoleType}, {notNull}, {size});
<!-- END BLOCK : primaryKeys -->

<!-- START BLOCK : columnsWhitoutKeys -->
		$tMap->addColumn('{name}', '{phpName}', '{type}', CreoleTypes::{creoleType}, {notNull}, {size});
<!-- END BLOCK : columnsWhitoutKeys -->

	} // doBuild()

} // {className}MapBuilder
