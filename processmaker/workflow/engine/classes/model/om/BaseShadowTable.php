<?php

require_once 'propel/om/BaseObject.php';

require_once 'propel/om/Persistent.php';


include_once 'propel/util/Criteria.php';

include_once 'classes/model/ShadowTablePeer.php';

/**
 * Base class that represents a row from the 'SHADOW_TABLE' table.
 *
 * 
 *
 * @package    workflow.classes.model.om
 */
abstract class BaseShadowTable extends BaseObject implements Persistent
{

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ShadowTablePeer
    */
    protected static $peer;

    /**
     * The value for the shd_uid field.
     * @var        string
     */
    protected $shd_uid = '';

    /**
     * The value for the add_tab_uid field.
     * @var        string
     */
    protected $add_tab_uid = '';

    /**
     * The value for the shd_action field.
     * @var        string
     */
    protected $shd_action = '';

    /**
     * The value for the shd_details field.
     * @var        string
     */
    protected $shd_details;

    /**
     * The value for the usr_uid field.
     * @var        string
     */
    protected $usr_uid = '';

    /**
     * The value for the app_uid field.
     * @var        string
     */
    protected $app_uid = '';

    /**
     * The value for the shd_date field.
     * @var        int
     */
    protected $shd_date;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Get the [shd_uid] column value.
     * 
     * @return     string
     */
    public function getShdUid()
    {

        return $this->shd_uid;
    }

    /**
     * Get the [add_tab_uid] column value.
     * 
     * @return     string
     */
    public function getAddTabUid()
    {

        return $this->add_tab_uid;
    }

    /**
     * Get the [shd_action] column value.
     * 
     * @return     string
     */
    public function getShdAction()
    {

        return $this->shd_action;
    }

    /**
     * Get the [shd_details] column value.
     * 
     * @return     string
     */
    public function getShdDetails()
    {

        return $this->shd_details;
    }

    /**
     * Get the [usr_uid] column value.
     * 
     * @return     string
     */
    public function getUsrUid()
    {

        return $this->usr_uid;
    }

    /**
     * Get the [app_uid] column value.
     * 
     * @return     string
     */
    public function getAppUid()
    {

        return $this->app_uid;
    }

    /**
     * Get the [optionally formatted] [shd_date] column value.
     * 
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                          If format is NULL, then the integer unix timestamp will be returned.
     * @return     mixed Formatted date/time value as string or integer unix timestamp (if format is NULL).
     * @throws     PropelException - if unable to convert the date/time to timestamp.
     */
    public function getShdDate($format = 'Y-m-d H:i:s')
    {

        if ($this->shd_date === null || $this->shd_date === '') {
            return null;
        } elseif (!is_int($this->shd_date)) {
            // a non-timestamp value was set externally, so we convert it
            $ts = strtotime($this->shd_date);
            if ($ts === -1 || $ts === false) {
                throw new PropelException("Unable to parse value of [shd_date] as date/time value: " .
                    var_export($this->shd_date, true));
            }
        } else {
            $ts = $this->shd_date;
        }
        if ($format === null) {
            return $ts;
        } elseif (strpos($format, '%') !== false) {
            return strftime($format, $ts);
        } else {
            return date($format, $ts);
        }
    }

    /**
     * Set the value of [shd_uid] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setShdUid($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->shd_uid !== $v || $v === '') {
            $this->shd_uid = $v;
            $this->modifiedColumns[] = ShadowTablePeer::SHD_UID;
        }

    } // setShdUid()

    /**
     * Set the value of [add_tab_uid] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setAddTabUid($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->add_tab_uid !== $v || $v === '') {
            $this->add_tab_uid = $v;
            $this->modifiedColumns[] = ShadowTablePeer::ADD_TAB_UID;
        }

    } // setAddTabUid()

    /**
     * Set the value of [shd_action] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setShdAction($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->shd_action !== $v || $v === '') {
            $this->shd_action = $v;
            $this->modifiedColumns[] = ShadowTablePeer::SHD_ACTION;
        }

    } // setShdAction()

    /**
     * Set the value of [shd_details] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setShdDetails($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->shd_details !== $v) {
            $this->shd_details = $v;
            $this->modifiedColumns[] = ShadowTablePeer::SHD_DETAILS;
        }

    } // setShdDetails()

    /**
     * Set the value of [usr_uid] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setUsrUid($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->usr_uid !== $v || $v === '') {
            $this->usr_uid = $v;
            $this->modifiedColumns[] = ShadowTablePeer::USR_UID;
        }

    } // setUsrUid()

    /**
     * Set the value of [app_uid] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setAppUid($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->app_uid !== $v || $v === '') {
            $this->app_uid = $v;
            $this->modifiedColumns[] = ShadowTablePeer::APP_UID;
        }

    } // setAppUid()

    /**
     * Set the value of [shd_date] column.
     * 
     * @param      int $v new value
     * @return     void
     */
    public function setShdDate($v)
    {

        if ($v !== null && !is_int($v)) {
            $ts = strtotime($v);
            //Date/time accepts null values
            if ($v == '') {
                $ts = null;
            }
            if ($ts === -1 || $ts === false) {
                throw new PropelException("Unable to parse date/time value for [shd_date] from input: " .
                    var_export($v, true));
            }
        } else {
            $ts = $v;
        }
        if ($this->shd_date !== $ts) {
            $this->shd_date = $ts;
            $this->modifiedColumns[] = ShadowTablePeer::SHD_DATE;
        }

    } // setShdDate()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (1-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param      ResultSet $rs The ResultSet class with cursor advanced to desired record pos.
     * @param      int $startcol 1-based offset column which indicates which restultset column to start with.
     * @return     int next starting column
     * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate(ResultSet $rs, $startcol = 1)
    {
        try {

            $this->shd_uid = $rs->getString($startcol + 0);

            $this->add_tab_uid = $rs->getString($startcol + 1);

            $this->shd_action = $rs->getString($startcol + 2);

            $this->shd_details = $rs->getString($startcol + 3);

            $this->usr_uid = $rs->getString($startcol + 4);

            $this->app_uid = $rs->getString($startcol + 5);

            $this->shd_date = $rs->getTimestamp($startcol + 6, null);

            $this->resetModified();

            $this->setNew(false);

            // FIXME - using NUM_COLUMNS may be clearer.
            return $startcol + 7; // 7 = ShadowTablePeer::NUM_COLUMNS - ShadowTablePeer::NUM_LAZY_LOAD_COLUMNS).

        } catch (Exception $e) {
            throw new PropelException("Error populating ShadowTable object", $e);
        }
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      Connection $con
     * @return     void
     * @throws     PropelException
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete($con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ShadowTablePeer::DATABASE_NAME);
        }

        try {
            $con->begin();
            ShadowTablePeer::doDelete($this, $con);
            $this->setDeleted(true);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
    }

    /**
     * Stores the object in the database.  If the object is new,
     * it inserts it; otherwise an update is performed.  This method
     * wraps the doSave() worker method in a transaction.
     *
     * @param      Connection $con
     * @return     int The number of rows affected by this insert/update
     * @throws     PropelException
     * @see        doSave()
     */
    public function save($con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(ShadowTablePeer::DATABASE_NAME);
        }

        try {
            $con->begin();
            $affectedRows = $this->doSave($con);
            $con->commit();
            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollback();
            throw $e;
        }
    }

    /**
     * Stores the object in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      Connection $con
     * @return     int The number of rows affected by this insert/update and any referring
     * @throws     PropelException
     * @see        save()
     */
    protected function doSave($con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;


            // If this object has been modified, then save it to the database.
            if ($this->isModified()) {
                if ($this->isNew()) {
                    $pk = ShadowTablePeer::doInsert($this, $con);
                    $affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
                                         // should always be true here (even though technically
                                         // BasePeer::doInsert() can insert multiple rows).

                    $this->setNew(false);
                } else {
                    $affectedRows += ShadowTablePeer::doUpdate($this, $con);
                }
                $this->resetModified(); // [HL] After being saved an object is no longer 'modified'
            }

            $this->alreadyInSave = false;
        }
        return $affectedRows;
    } // doSave()

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return     array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param      mixed $columns Column name or an array of column names.
     * @return     boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();
            return true;
        } else {
            $this->validationFailures = $res;
            return false;
        }
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param      array $columns Array of column names to validate.
     * @return     mixed <code>true</code> if all validations pass; 
                   array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = ShadowTablePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }



            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TYPE_PHPNAME,
     *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
     * @return     mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ShadowTablePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        return $this->getByPosition($pos);
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return     mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch($pos) {
            case 0:
                return $this->getShdUid();
                break;
            case 1:
                return $this->getAddTabUid();
                break;
            case 2:
                return $this->getShdAction();
                break;
            case 3:
                return $this->getShdDetails();
                break;
            case 4:
                return $this->getUsrUid();
                break;
            case 5:
                return $this->getAppUid();
                break;
            case 6:
                return $this->getShdDate();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param      string $keyType One of the class type constants TYPE_PHPNAME,
     *                        TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
     * @return     an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ShadowTablePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getShdUid(),
            $keys[1] => $this->getAddTabUid(),
            $keys[2] => $this->getShdAction(),
            $keys[3] => $this->getShdDetails(),
            $keys[4] => $this->getUsrUid(),
            $keys[5] => $this->getAppUid(),
            $keys[6] => $this->getShdDate(),
        );
        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name peer name
     * @param      mixed $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TYPE_PHPNAME,
     *                     TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM
     * @return     void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = ShadowTablePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return     void
     */
    public function setByPosition($pos, $value)
    {
        switch($pos) {
            case 0:
                $this->setShdUid($value);
                break;
            case 1:
                $this->setAddTabUid($value);
                break;
            case 2:
                $this->setShdAction($value);
                break;
            case 3:
                $this->setShdDetails($value);
                break;
            case 4:
                $this->setUsrUid($value);
                break;
            case 5:
                $this->setAppUid($value);
                break;
            case 6:
                $this->setShdDate($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME,
     * TYPE_NUM. The default key type is the column's phpname (e.g. 'authorId')
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return     void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = ShadowTablePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setShdUid($arr[$keys[0]]);
        }

        if (array_key_exists($keys[1], $arr)) {
            $this->setAddTabUid($arr[$keys[1]]);
        }

        if (array_key_exists($keys[2], $arr)) {
            $this->setShdAction($arr[$keys[2]]);
        }

        if (array_key_exists($keys[3], $arr)) {
            $this->setShdDetails($arr[$keys[3]]);
        }

        if (array_key_exists($keys[4], $arr)) {
            $this->setUsrUid($arr[$keys[4]]);
        }

        if (array_key_exists($keys[5], $arr)) {
            $this->setAppUid($arr[$keys[5]]);
        }

        if (array_key_exists($keys[6], $arr)) {
            $this->setShdDate($arr[$keys[6]]);
        }

    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return     Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ShadowTablePeer::DATABASE_NAME);

        if ($this->isColumnModified(ShadowTablePeer::SHD_UID)) {
            $criteria->add(ShadowTablePeer::SHD_UID, $this->shd_uid);
        }

        if ($this->isColumnModified(ShadowTablePeer::ADD_TAB_UID)) {
            $criteria->add(ShadowTablePeer::ADD_TAB_UID, $this->add_tab_uid);
        }

        if ($this->isColumnModified(ShadowTablePeer::SHD_ACTION)) {
            $criteria->add(ShadowTablePeer::SHD_ACTION, $this->shd_action);
        }

        if ($this->isColumnModified(ShadowTablePeer::SHD_DETAILS)) {
            $criteria->add(ShadowTablePeer::SHD_DETAILS, $this->shd_details);
        }

        if ($this->isColumnModified(ShadowTablePeer::USR_UID)) {
            $criteria->add(ShadowTablePeer::USR_UID, $this->usr_uid);
        }

        if ($this->isColumnModified(ShadowTablePeer::APP_UID)) {
            $criteria->add(ShadowTablePeer::APP_UID, $this->app_uid);
        }

        if ($this->isColumnModified(ShadowTablePeer::SHD_DATE)) {
            $criteria->add(ShadowTablePeer::SHD_DATE, $this->shd_date);
        }


        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return     Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(ShadowTablePeer::DATABASE_NAME);

        $criteria->add(ShadowTablePeer::SHD_UID, $this->shd_uid);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return     string
     */
    public function getPrimaryKey()
    {
        return $this->getShdUid();
    }

    /**
     * Generic method to set the primary key (shd_uid column).
     *
     * @param      string $key Primary key.
     * @return     void
     */
    public function setPrimaryKey($key)
    {
        $this->setShdUid($key);
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of ShadowTable (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @throws     PropelException
     */
    public function copyInto($copyObj, $deepCopy = false)
    {

        $copyObj->setAddTabUid($this->add_tab_uid);

        $copyObj->setShdAction($this->shd_action);

        $copyObj->setShdDetails($this->shd_details);

        $copyObj->setUsrUid($this->usr_uid);

        $copyObj->setAppUid($this->app_uid);

        $copyObj->setShdDate($this->shd_date);


        $copyObj->setNew(true);

        $copyObj->setShdUid(''); // this is a pkey column, so set to default value

    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return     ShadowTable Clone of current object.
     * @throws     PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);
        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return     ShadowTablePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ShadowTablePeer();
        }
        return self::$peer;
    }
}

