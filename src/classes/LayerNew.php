<?php


class LayerNew
{
    // ----- START OF ACTIVE RECORD CODE ------
    static public $database;
    static public $db_columns = ['id', 'name', 'path', 'style'];

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

    public function create() {
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO layer (";
        $sql .= join(', ', array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("' , '", array_values($attributes));
        $sql .= "')";
        $result = self::$database->query($sql);
        if($result) {
            $this->id = self::$database->insert_id;
        }
        return $result;
    }

    // Properties which have database columns, excluding ID
    public function attributes() {
        $attributes = [];
        foreach(self::$db_columns as $column) {
            if($column == 'id') { continue; }
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    protected function sanitized_attributes() {
        $sanitized = [];
        foreach($this->attributes() as $key => $value) {
            $sanitized[$key] = self::$database->escape_string($value);
        }
        return $sanitized;
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