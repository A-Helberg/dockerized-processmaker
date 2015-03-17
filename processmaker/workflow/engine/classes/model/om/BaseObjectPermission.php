<?php

require_once 'propel/om/BaseObject.php';

require_once 'propel/om/Persistent.php';


include_once 'propel/util/Criteria.php';

include_once 'classes/model/ObjectPermissionPeer.php';

/**
 * Base class that represents a row from the 'OBJECT_PERMISSION' table.
 *
 * 
 *
 * @package    workflow.classes.model.om
 */
abstract class BaseObjectPermission extends BaseObject implements Persistent
{

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ObjectPermissionPeer
    */
    protected static $peer;

    /**
     * The value for the op_uid field.
     * @var        string
     */
    protected $op_uid = '0';

    /**
     * The value for the pro_uid field.
     * @var        string
     */
    protected $pro_uid = '0';

    /**
     * The value for the tas_uid field.
     * @var        string
     */
    protected $tas_uid = '0';

    /**
     * The value for the usr_uid field.
     * @var        string
     */
    protected $usr_uid = '0';

    /**
     * The value for the op_user_relation field.
     * @var        int
     */
    protected $op_user_relation = 0;

    /**
     * The value for the op_task_source field.
     * @var        string
     */
    protected $op_task_source = '0';

    /**
     * The value for the op_participate field.
     * @var        int
     */
    protected $op_participate = 0;

    /**
     * The value for the op_obj_type field.
     * @var        string
     */
    protected $op_obj_type = '0';

    /**
     * The value for the op_obj_uid field.
     * @var        string
     */
    protected $op_obj_uid = '0';

    /**
     * The value for the op_action field.
     * @var        string
     */
    protected $op_action = '0';

    /**
     * The value for the op_case_status field.
     * @var        string
     */
    protected $op_case_status = '0';

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
     * Get the [op_uid] column value.
     * 
     * @return     string
     */
    public function getOpUid()
    {

        return $this->op_uid;
    }

    /**
     * Get the [pro_uid] column value.
     * 
     * @return     string
     */
    public function getProUid()
    {

        return $this->pro_uid;
    }

    /**
     * Get the [tas_uid] column value.
     * 
     * @return     string
     */
    public function getTasUid()
    {

        return $this->tas_uid;
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
     * Get the [op_user_relation] column value.
     * 
     * @return     int
     */
    public function getOpUserRelation()
    {

        return $this->op_user_relation;
    }

    /**
     * Get the [op_task_source] column value.
     * 
     * @return     string
     */
    public function getOpTaskSource()
    {

        return $this->op_task_source;
    }

    /**
     * Get the [op_participate] column value.
     * 
     * @return     int
     */
    public function getOpParticipate()
    {

        return $this->op_participate;
    }

    /**
     * Get the [op_obj_type] column value.
     * 
     * @return     string
     */
    public function getOpObjType()
    {

        return $this->op_obj_type;
    }

    /**
     * Get the [op_obj_uid] column value.
     * 
     * @return     string
     */
    public function getOpObjUid()
    {

        return $this->op_obj_uid;
    }

    /**
     * Get the [op_action] column value.
     * 
     * @return     string
     */
    public function getOpAction()
    {

        return $this->op_action;
    }

    /**
     * Get the [op_case_status] column value.
     * 
     * @return     string
     */
    public function getOpCaseStatus()
    {

        return $this->op_case_status;
    }

    /**
     * Set the value of [op_uid] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setOpUid($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->op_uid !== $v || $v === '0') {
            $this->op_uid = $v;
            $this->modifiedColumns[] = ObjectPermissionPeer::OP_UID;
        }

    } // setOpUid()

    /**
     * Set the value of [pro_uid] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setProUid($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->pro_uid !== $v || $v === '0') {
            $this->pro_uid = $v;
            $this->modifiedColumns[] = ObjectPermissionPeer::PRO_UID;
        }

    } // setProUid()

    /**
     * Set the value of [tas_uid] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setTasUid($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->tas_uid !== $v || $v === '0') {
            $this->tas_uid = $v;
            $this->modifiedColumns[] = ObjectPermissionPeer::TAS_UID;
        }

    } // setTasUid()

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

        if ($this->usr_uid !== $v || $v === '0') {
            $this->usr_uid = $v;
            $this->modifiedColumns[] = ObjectPermissionPeer::USR_UID;
        }

    } // setUsrUid()

    /**
     * Set the value of [op_user_relation] column.
     * 
     * @param      int $v new value
     * @return     void
     */
    public function setOpUserRelation($v)
    {

        // Since the native PHP type for this column is integer,
        // we will cast the input value to an int (if it is not).
        if ($v !== null && !is_int($v) && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->op_user_relation !== $v || $v === 0) {
            $this->op_user_relation = $v;
            $this->modifiedColumns[] = ObjectPermissionPeer::OP_USER_RELATION;
        }

    } // setOpUserRelation()

    /**
     * Set the value of [op_task_source] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setOpTaskSource($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->op_task_source !== $v || $v === '0') {
            $this->op_task_source = $v;
            $this->modifiedColumns[] = ObjectPermissionPeer::OP_TASK_SOURCE;
        }

    } // setOpTaskSource()

    /**
     * Set the value of [op_participate] column.
     * 
     * @param      int $v new value
     * @return     void
     */
    public function setOpParticipate($v)
    {

        // Since the native PHP type for this column is integer,
        // we will cast the input value to an int (if it is not).
        if ($v !== null && !is_int($v) && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->op_participate !== $v || $v === 0) {
            $this->op_participate = $v;
            $this->modifiedColumns[] = ObjectPermissionPeer::OP_PARTICIPATE;
        }

    } // setOpParticipate()

    /**
     * Set the value of [op_obj_type] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setOpObjType($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->op_obj_type !== $v || $v === '0') {
            $this->op_obj_type = $v;
            $this->modifiedColumns[] = ObjectPermissionPeer::OP_OBJ_TYPE;
        }

    } // setOpObjType()

    /**
     * Set the value of [op_obj_uid] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setOpObjUid($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->op_obj_uid !== $v || $v === '0') {
            $this->op_obj_uid = $v;
            $this->modifiedColumns[] = ObjectPermissionPeer::OP_OBJ_UID;
        }

    } // setOpObjUid()

    /**
     * Set the value of [op_action] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setOpAction($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->op_action !== $v || $v === '0') {
            $this->op_action = $v;
            $this->modifiedColumns[] = ObjectPermissionPeer::OP_ACTION;
        }

    } // setOpAction()

    /**
     * Set the value of [op_case_status] column.
     * 
     * @param      string $v new value
     * @return     void
     */
    public function setOpCaseStatus($v)
    {

        // Since the native PHP type for this column is string,
        // we will cast the input to a string (if it is not).
        if ($v !== null && !is_string($v)) {
            $v = (string) $v;
        }

        if ($this->op_case_status !== $v || $v === '0') {
            $this->op_case_status = $v;
            $this->modifiedColumns[] = ObjectPermissionPeer::OP_CASE_STATUS;
        }

    } // setOpCaseStatus()

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

            $this->op_uid = $rs->getString($startcol + 0);

            $this->pro_uid = $rs->getString($startcol + 1);

            $this->tas_uid = $rs->getString($startcol + 2);

            $this->usr_uid = $rs->getString($startcol + 3);

            $this->op_user_relation = $rs->getInt($startcol + 4);

            $this->op_task_source = $rs->getString($startcol + 5);

            $this->op_participate = $rs->getInt($startcol + 6);

            $this->op_obj_type = $rs->getString($startcol + 7);

            $this->op_obj_uid = $rs->getString($startcol + 8);

            $this->op_action = $rs->getString($startcol + 9);

            $this->op_case_status = $rs->getString($startcol + 10);

            $this->resetModified();

            $this->setNew(false);

            // FIXME - using NUM_COLUMNS may be clearer.
            return $startcol + 11; // 11 = ObjectPermissionPeer::NUM_COLUMNS - ObjectPermissionPeer::NUM_LAZY_LOAD_COLUMNS).

        } catch (Exception $e) {
            throw new PropelException("Error populating ObjectPermission object", $e);
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
            $con = Propel::getConnection(ObjectPermissionPeer::DATABASE_NAME);
        }

        try {
            $con->begin();
            ObjectPermissionPeer::doDelete($this, $con);
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
            $con = Propel::getConnection(ObjectPermissionPeer::DATABASE_NAME);
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
                    $pk = ObjectPermissionPeer::doInsert($this, $con);
                    $affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
                                         // should always be true here (even though technically
                                         // BasePeer::doInsert() can insert multiple rows).

                    $this->setNew(false);
                } else {
                    $affectedRows += ObjectPermissionPeer::doUpdate($this, $con);
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


            if (($retval = ObjectPermissionPeer::doValidate($this, $columns)) !== true) {
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
        $pos = ObjectPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getOpUid();
                break;
            case 1:
                return $this->getProUid();
                break;
            case 2:
                return $this->getTasUid();
                break;
            case 3:
                return $this->getUsrUid();
                break;
            case 4:
                return $this->getOpUserRelation();
                break;
            case 5:
                return $this->getOpTaskSource();
                break;
            case 6:
                return $this->getOpParticipate();
                break;
            case 7:
                return $this->getOpObjType();
                break;
            case 8:
                return $this->getOpObjUid();
                break;
            case 9:
                return $this->getOpAction();
                break;
            case 10:
                return $this->getOpCaseStatus();
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
        $keys = ObjectPermissionPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getOpUid(),
            $keys[1] => $this->getProUid(),
            $keys[2] => $this->getTasUid(),
            $keys[3] => $this->getUsrUid(),
            $keys[4] => $this->getOpUserRelation(),
            $keys[5] => $this->getOpTaskSource(),
            $keys[6] => $this->getOpParticipate(),
            $keys[7] => $this->getOpObjType(),
            $keys[8] => $this->getOpObjUid(),
            $keys[9] => $this->getOpAction(),
            $keys[10] => $this->getOpCaseStatus(),
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
        $pos = ObjectPermissionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                $this->setOpUid($value);
                break;
            case 1:
                $this->setProUid($value);
                break;
            case 2:
                $this->setTasUid($value);
                break;
            case 3:
                $this->setUsrUid($value);
                break;
            case 4:
                $this->setOpUserRelation($value);
                break;
            case 5:
                $this->setOpTaskSource($value);
                break;
            case 6:
                $this->setOpParticipate($value);
                break;
            case 7:
                $this->setOpObjType($value);
                break;
            case 8:
                $this->setOpObjUid($value);
                break;
            case 9:
                $this->setOpAction($value);
                break;
            case 10:
                $this->setOpCaseStatus($value);
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
        $keys = ObjectPermissionPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setOpUid($arr[$keys[0]]);
        }

        if (array_key_exists($keys[1], $arr)) {
            $this->setProUid($arr[$keys[1]]);
        }

        if (array_key_exists($keys[2], $arr)) {
            $this->setTasUid($arr[$keys[2]]);
        }

        if (array_key_exists($keys[3], $arr)) {
            $this->setUsrUid($arr[$keys[3]]);
        }

        if (array_key_exists($keys[4], $arr)) {
            $this->setOpUserRelation($arr[$keys[4]]);
        }

        if (array_key_exists($keys[5], $arr)) {
            $this->setOpTaskSource($arr[$keys[5]]);
        }

        if (array_key_exists($keys[6], $arr)) {
            $this->setOpParticipate($arr[$keys[6]]);
        }

        if (array_key_exists($keys[7], $arr)) {
            $this->setOpObjType($arr[$keys[7]]);
        }

        if (array_key_exists($keys[8], $arr)) {
            $this->setOpObjUid($arr[$keys[8]]);
        }

        if (array_key_exists($keys[9], $arr)) {
            $this->setOpAction($arr[$keys[9]]);
        }

        if (array_key_exists($keys[10], $arr)) {
            $this->setOpCaseStatus($arr[$keys[10]]);
        }

    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return     Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ObjectPermissionPeer::DATABASE_NAME);

        if ($this->isColumnModified(ObjectPermissionPeer::OP_UID)) {
            $criteria->add(ObjectPermissionPeer::OP_UID, $this->op_uid);
        }

        if ($this->isColumnModified(ObjectPermissionPeer::PRO_UID)) {
            $criteria->add(ObjectPermissionPeer::PRO_UID, $this->pro_uid);
        }

        if ($this->isColumnModified(ObjectPermissionPeer::TAS_UID)) {
            $criteria->add(ObjectPermissionPeer::TAS_UID, $this->tas_uid);
        }

        if ($this->isColumnModified(ObjectPermissionPeer::USR_UID)) {
            $criteria->add(ObjectPermissionPeer::USR_UID, $this->usr_uid);
        }

        if ($this->isColumnModified(ObjectPermissionPeer::OP_USER_RELATION)) {
            $criteria->add(ObjectPermissionPeer::OP_USER_RELATION, $this->op_user_relation);
        }

        if ($this->isColumnModified(ObjectPermissionPeer::OP_TASK_SOURCE)) {
            $criteria->add(ObjectPermissionPeer::OP_TASK_SOURCE, $this->op_task_source);
        }

        if ($this->isColumnModified(ObjectPermissionPeer::OP_PARTICIPATE)) {
            $criteria->add(ObjectPermissionPeer::OP_PARTICIPATE, $this->op_participate);
        }

        if ($this->isColumnModified(ObjectPermissionPeer::OP_OBJ_TYPE)) {
            $criteria->add(ObjectPermissionPeer::OP_OBJ_TYPE, $this->op_obj_type);
        }

        if ($this->isColumnModified(ObjectPermissionPeer::OP_OBJ_UID)) {
            $criteria->add(ObjectPermissionPeer::OP_OBJ_UID, $this->op_obj_uid);
        }

        if ($this->isColumnModified(ObjectPermissionPeer::OP_ACTION)) {
            $criteria->add(ObjectPermissionPeer::OP_ACTION, $this->op_action);
        }

        if ($this->isColumnModified(ObjectPermissionPeer::OP_CASE_STATUS)) {
            $criteria->add(ObjectPermissionPeer::OP_CASE_STATUS, $this->op_case_status);
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
        $criteria = new Criteria(ObjectPermissionPeer::DATABASE_NAME);

        $criteria->add(ObjectPermissionPeer::OP_UID, $this->op_uid);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return     string
     */
    public function getPrimaryKey()
    {
        return $this->getOpUid();
    }

    /**
     * Generic method to set the primary key (op_uid column).
     *
     * @param      string $key Primary key.
     * @return     void
     */
    public function setPrimaryKey($key)
    {
        $this->setOpUid($key);
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of ObjectPermission (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @throws     PropelException
     */
    public function copyInto($copyObj, $deepCopy = false)
    {

        $copyObj->setProUid($this->pro_uid);

        $copyObj->setTasUid($this->tas_uid);

        $copyObj->setUsrUid($this->usr_uid);

        $copyObj->setOpUserRelation($this->op_user_relation);

        $copyObj->setOpTaskSource($this->op_task_source);

        $copyObj->setOpParticipate($this->op_participate);

        $copyObj->setOpObjType($this->op_obj_type);

        $copyObj->setOpObjUid($this->op_obj_uid);

        $copyObj->setOpAction($this->op_action);

        $copyObj->setOpCaseStatus($this->op_case_status);


        $copyObj->setNew(true);

        $copyObj->setOpUid('0'); // this is a pkey column, so set to default value

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
     * @return     ObjectPermission Clone of current object.
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
     * @return     ObjectPermissionPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ObjectPermissionPeer();
        }
        return self::$peer;
    }
}

