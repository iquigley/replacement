<?php
/**
 * For any database technology that you wish to incorporate into this system, you must
 * implement this Interface to account for all CRUD operations. Specify the implemented
 * DataBase Adapter in the base DataStoreObject class.
 *
 * @author ike
 * Last Updated 03/31/2020
 */

interface DataAdapterInterface {


    public static function create(array $data_array, string $data_table);

    public static function read(array $condition_array, string $data_table, string $class);

    public static function readAll(array $condition_array, string $data_table, string $class);

    public static function update(array $data_array, string $data_table);

    public static function delete(DataStoreObject $data_object);


}
