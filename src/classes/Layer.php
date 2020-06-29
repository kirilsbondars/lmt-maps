<?php
require_once("DatabaseObject.php");

class Layer extends DatabaseObject
{
    public $target_file, $id, $name, $type, $style;

    public function add_to_db() {
        return self::find_by_sql("INSERT INTO lmt_map.layer(name, path, style) VALUES ('$this->name', '$this->target_file', '$this->style')");
    }

    public static function get_all() {
        $layers = array();

        $result = self::find_by_sql("SELECT id, name, style FROM layer");
        if ($result->num_rows > 0) {
            for($i = 1; $row = $result->fetch_assoc(); $i++) {
                 $layers[$i] = $row;
            }
        }

        return $layers;
    }

    public static function delete_from_db($id) {
        return self::find_by_sql("DELETE FROM layer WHERE id = $id");
    }

    public function data_from_db() {
        $result = self::find_by_sql("SELECT name, path, style FROM layer WHERE id = $this->id");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->name = $row["name"];
            $this->target_file = $row["path"];
            $this->style = $row["style"];
        }
    }
}