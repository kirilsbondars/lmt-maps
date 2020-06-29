<?php

class DatabaseObject
{
    static protected $database;

    static public function set_database($database) {
        self::$database = $database;
    }

    static public function find_by_sql($sql) {
        $result = self::$database->query($sql);
        if(!$result) {
            exit("Database query failed.");
        }
        return $result;
    }

    static public function find_by_sql_single($sql) {
        $result = self::find_by_sql($sql);
        if($result->num_rows == 1)
            return array_values($result->fetch_assoc())[0];
        else
            return false;
    }

    static public function run_sql($sql) {
        $result = self::$database->query($sql);
        if(!$result) {
            exit("Database query failed.");
        }
    }
}