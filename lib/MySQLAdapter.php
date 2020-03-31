<?php
/**
 * MySQL specific DataStoreAdaptor. The code below is adapted from the custom system
 * I created for DBC.
 *
 * @author ike
 */

class MySQLAdapter implements DataAdapterInterface {

    private static $connector;
    private const dbName = DB_NAME;
    private const dbUser = DB_USER;
    private const dbPass = DB_PASS;
    private const dbHost= DB_HOST;
    private const dbPort = DB_PORT;

    public static function create(array $data_array, string $data_table) {
        //build the query
        $query = "INSERT INTO {$data_table} ";
        $columns = "( ";
        $values = " VALUES ( ";
        foreach ($data_array as $name => $value) {
            if (!is_null($value) && $value !== "") {
                $value = static::dbSafeString($value);
                $columns.= "{$name}, ";
                $values.="'{$value}', ";
            }
        }
        //remove last comma
        $columns = substr($columns, 0, strlen($columns) - 2);
        $values = substr($values, 0, strlen($values) - 2);
        //add the end parenthesis
        $columns.= " )";
        $values.=" )";
        //run the query
        $query.= $columns . $values;
        // Run update query with new flag set to true.
        $key = self::runUpdateQuery($query, true);
        return $key;
    }

    public static function read(array $condition_array, string $data_table, string $class) {
        $result = static::readAll($condition_array, $data_table, $class);
        return array_pop($result);
    }

    public static function readAll(array $condition_array, string $data_table, string $class) {
        // Build a SELECT Query.
        $query = "SELECT * FROM {$data_table} ";
        // Add a condition if specified.
        if (!empty($condition_array)) {
            $query.= "WHERE ";
            foreach ($condition_array as $name=>$value) {
                $query.= "{$name} = \"{$value}\" AND";
            }
            // Remove the last AND
            $query = substr($query, 0, -3);
        }
        // Return the array of objects.
        $objectArray = self::runLoadQuery($query, $class);
        // Return results
        return $objectArray;
    }

    /**
     * Handles the Update function.
     * @param array $data_array
     * @param string $data_table
     * @return type
     */
    public static function update(array $data_array, string $data_table) {
        $query = "UPDATE {$data_table} SET ";
        // Build a query based on what is left.
        foreach ($data_array as $name => $value) {
            if ($value !== null && $value !== ''){
                $value = static::dbSafeString($value);
                $query.= "{$name}  = '{$value}',";
            } else {
                $query.= "{$name}  = NULL,";
            }
        }
        // Remove the last comma.
        $query = substr($query, 0, strlen($query) - 1);
        //add the where condition
        $query.= " WHERE uuid = '" .$data_array['uuid'] . "'";
        //run the query
        $result = self::runUpdateQuery($query, false);
        return $result;
    }

    public static function delete(\DataStoreObject $data_object) {
        $query = "DELETE FROM {$data_object::getDataBaseTable()} WHERE uuid = '{$data_object->getUuid()}'";
        return static::runQuery($query);
    }


    protected static function runQuery($query) {
        $connector = static::getConnector();
        try {
            // Fetch into an PDOStatement object.
            $sth = $connector->prepare($query);
            $sth->execute();
            $result = $sth->fetchAll();
        } catch (\PDOException $e) {
            // Report any query errors.
            foreach($connector->errorInfo() as $error) {
                error_log("PDO Error: ". $error);
            }
            return false;
        }
        return $result;
    }

    private static function runUpdateQuery($query, $new = false) {
        // Run the query.
        $connector = static::getConnector();
        try {
            // Fetch into an PDOStatement object.
            $result = $connector->exec($query);
            // If this is a new record, return the new id.
            if ($new) {
                return $connector->lastInsertId();
            }
            // Return the number of affected rows.
            return $result;

        } catch (\PDOException $e) {
            // Report any query errors.
            foreach( $connector->errorInfo() as $error) {
                error_log("PDO Error: ".$error);
            }
        }
        // No results to display. Return false.
        return false;
    }

    protected static function runLoadQuery($query, $class) {
        $connector = static::getConnector();
        // Run the query.
        try {
            // Fetch into an PDOStatement object.
            $result = $connector->query($query);
            // Fetch into the specified class if there are results.
            if ($result) {
                return  $result->fetchALL(PDO::FETCH_CLASS, $class);
            }
            // Else there are no results. Return empty array.
            return array();

        } catch (\PDOException $e) {
            // Report any query errors
            foreach($connector ->errorInfo() as $error) {
                error_log("PDO Error: ". $error);
            }
        }
        // No results to display. Return false.
        return false;
    }


    private static function dbSafeString($string) {
       $string = trim($string);
       $string = htmlentities($string,ENT_QUOTES);
       return addslashes($string);
    }

    private static function getConnector() {
        // Check to see if the required connection has been made.
        if (!empty(static::$connector)) {
            return static::$connector;
        }
        // Try connecting.
        try {
            static::$connector = new PDO("mysql:dbname=". static::dbName .
                                         ";host=". static::dbHost .
                                         ";port=". static::dbPort,
                                         static::dbUser, static::dbPass);
            static::$connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(\PDOException $e){
            error_log("PDO Error Message: " . $e->getMessage());
            return false;
        }
        return static::$connector;
    }
}
