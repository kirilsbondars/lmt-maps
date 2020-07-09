<?php


class LayerNew
{
    // ----- START OF ACTIVE RECORD CODE ------
    static public $database;

    static public function set_database($database) {
        self::$database = $database;
    }

    static public function find_by_sql($sql) {
        $result = self::$database->query($sql);
        if(!$result) {
            exit("Database query failed.");
        }

        // results into object
        $object_array = [];
        while($record = $result->fetch_assoc()) {
            $object_array[] = self::instantiate($record);
        }

        $result->free();

        return $object_array;
    }

    static public function find_all() {
        $sql = "SELECT * FROM layer";
        return self::find_by_sql($sql);
    }

    static public function find_by_id($id) {
        $sql = "SELECT * FROM layer ";
        $sql .= "WHERE id='" . self::$database->escape_string($id) . "'";
        $obj_array = self::find_by_sql($sql);
        if(!empty($obj_array)) {
            return array_shift($obj_array);
        } else {
            return false;
        }
    }

    static protected function instantiate($record) {
        $object = new self;

        foreach($record as $property => $value) {
            if(property_exists($object, $property)) {
                $object->$property = $value;
            }
        }
        return $object;
    }
    // ----- END OF ACTIVE RECORD CODE ------

    public $id, $name, $path, $style, $type;

    public function __construct($args=[])
    {
        $this->id = $args['id'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->path = $args['path'] ?? '';
        $this->style = $args['style'] ?? '';
    }

    public function type() {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }
}