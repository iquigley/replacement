<?php
/**
 * Base class for any object saving or loading from the data storage device.
 * Each inherited class will specify the associated class for reading and writing
 * to the database, plus the table associated with this class type, and the unique
 * fields that should be saved.
 *
 * @author ike
 * Last Updated 03/31/2020
 */

abstract class DataStoreObject {

    // Each inherited class should specify the name of the table in the DB.
    protected static $db_table = "";
    // Specify the class being used for connecting to the datastore.
    protected static $data_adapter = "MySQLAdapter";
    // These fields should be saved to the associated data table.
    protected static $data_field_array = array("id", "uuid", "name", "date_created");

    protected $id;
    protected $uuid;
    protected $name;
    protected $date_created;


    // ======================== SAVE & DELETE ====================================

    /**
     * Generic method for saving data to the database. Each class has a name-value
     * pair matrix of data that gets saved.
     * @return $this
     */
    public function save() {
        $adapterClass = static::getAdapterClass();
        // Check if this is a new object or an existing object. New objects won't have
        // Ids.
        if ($this->id === null) {
            // New object, so generate a UUID.
            $this->generateUuid();
            // Record the date this object was created.
            $this->generateDateCreated();
            // Call on the DB Store adapter and create a new record.
            $this->id = $adapterClass::create($this->generateNameValueMatrix(), static::getDataBaseTable());
            return $this;
        } else {
        // Else update existing record.
            return $adapterClass::update($this->generateNameValueMatrix(), static::getDataBaseTable());
        }
    }

    /**
     * Delete an object form the database.
     * @return bool
     */
    public function delete() {
        $adapterClass = static::getAdapterClass();
        return $adapterClass::delete($this);
    }

    // ============================= LOADERS =======================================

    /**
     * Generic load object by UUID.
     * @param string $uuid
     * @return DataStoreObject
     */
    public static function loadByUuid($uuid) {
        $adapterClass = static::getAdapterClass();
        $condition = array("uuid"=>$uuid);
        return $adapterClass::read($condition, static::getDataBaseTable(), get_called_class());
    }

    /**
     * Load object by name.
     * @param string $name
     * @return DataStoreObject
     */
    public static function loadByName($name) {
        $adapterClass = static::getAdapterClass();
        $condition = array("name"=>$name);
        return $adapterClass::read($condition, static::getDataBaseTable(), get_called_class());
    }

    /**
     * Load all objects from the database of this inherited type.
     * @return [DataStoreObject]
     */
    public static function loadAll() {
        $adapterClass = static::getAdapterClass();
        return $adapterClass::readAll(array(), static::getDataBaseTable(), get_called_class());
    }


    // =============== HELPER METHODS FOR DATA STORAGE ===============================

    /**
     * This method generates an associative array of name-value pairs that represent
     * the fields and values that will be stored in the database. The specific field
     * names are generated by the getDataFieldArray method below.
     * @return [string]
     */
    protected function generateNameValueMatrix() {
        $fields = static::getDataFieldArray();
        $matrix = array();
        foreach ($fields as $name) {
            $matrix[$name] = $this->{$name};
        }
        return $matrix;
    }

    /**
     * This method recursively iterates up the chain of inheritance to merge all the
     * data_field_array values into one array. This method is used by the generateNameValueMatrix
     * for generating a name-value associative array to be passed to the database.
     * @param [string] $childArray
     * @param [string] $thisClass
     * @return [string]
     */
    protected static function getDataFieldArray($childArray = array(), $thisClass = null) {
        // The first iteration the class is dynamically pulled and not specified.
        if ($thisClass == null) {
            $thisClass = get_called_class();
        }
        // Get the parent class of this class.
        $parentClass = get_parent_class($thisClass);
        // Check to see if there is no parent, which means we're at the root parent.
        if ($parentClass === false) {
            return array_merge(static::$data_field_array, $childArray);
        // Make sure that the parent class has the getDataFieldArray method.
        } elseif (!method_exists($parentClass, "getDataFieldArray")) {
            return array_merge(static::$data_field_array, $childArray);
        // Else, we're in a child class, so recursively call the parent method and merge with this array.
        } else {
            return $parentClass::getDataFieldArray(array_merge($thisClass::$data_field_array, $childArray), $parentClass);
        }
    }


    // ========================== GENERATORS ========================================

    public function generateUuid() {
        $this->uuid = uniqid();
    }

    public function generateDateCreated() {
        $this->date_created = time();
    }

    //============================== GETTERS ==============================

    public function getId() {
        return $this->id;
    }

    public function getUuid() {
        return $this->uuid;
    }

    public function getName() {
        return $this->name;
    }

    public function getDateCreated() {
        return $this->date_created;
    }

    public static function getDataBaseTable() {
        return static::$db_table;
    }

    protected static function getAdapterClass() {
        return static::$data_adapter;
    }

    //============================== SETTERS ==============================

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setUuid($uuid) {
        $this->uuid = $uuid;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setDateCreated($date_created) {
        $this->date_created = $date_created;
        return $this;
    }

}