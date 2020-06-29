<?php
require_once("DatabaseObject.php");

class Layer extends DatabaseObject
{
    public $id, $name, $target_file, $style, $type;

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

    public function delete_from_db() {
        return self::find_by_sql("DELETE FROM layer WHERE id = $this->id");
    }

    public static function add_to_db($name, $path, $style) {
        return self::find_by_sql("INSERT INTO lmt_map.layer(name, path, style) VALUES ('$name', '$path', '$style')");
    }

    public function __construct($id) {
        $this->id = $id;

        $result = self::find_by_sql("SELECT name, path, style FROM lmt_map.layer WHERE id = $this->id");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $this->name = $row["name"];
            $this->target_file = $row["path"];
            $this->style = $row["style"];

            $last_point = strrpos($this->target_file, ".");
            $this->type = substr($this->target_file, $last_point + 1);
        }
    }
}