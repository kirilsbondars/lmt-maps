<?php
require_once("DatabaseObject.php");

class Layer extends DatabaseObject
{
    public $id, $name, $target_file, $style, $type;

    public static function get_all() {
        $layers = array();

        $result = self::find_by_sql("SELECT id, name, path, style FROM layer");
        if ($result->num_rows > 0) {
            for($i = 0; $row = $result->fetch_assoc(); $i++) {
                 $layers[$i] = new Layer($row["id"], $row["name"], $row["path"], $row["style"]);
            }
        }

        return $layers;
    }

    public function delete_from_db() {
        self::find_by_sql("DELETE FROM layer WHERE id = $this->id");
    }

    public static function add_to_db($name, $path) {
        $layer = new Layer($name, $path);

        self::run_sql("INSERT INTO lmt_map.layer(name, path, style) VALUES ('" .$layer->name. "', '" .$layer->target_file. "', '" .$layer->style. "')");
        $result = self::find_by_sql("SELECT id FROM lmt_map.layer WHERE path = '$path'");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $layer->id = $row["id"];
        }

        return $layer;
    }

    public function change() {
        return self::find_by_sql("UPDATE lmt_map.layer SET name = '$this->name', style = '$this->style' WHERE id = $this->id");
    }

    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    public static function getPath($id) {
        return self::find_by_sql_single("SELECT path FROM lmt_map.layer WHERE id = $id");
    }

    public static function getStyle($id) {
        return self::find_by_sql_single("SELECT style FROM lmt_map.layer WHERE id = $id");
    }

    public function __construct0()
    {
    }

    public function __construct2($name, $target_file)
    {
        $this->name = $name;
        $this->target_file = $target_file;
        $this->makeType();
        $this->setDefaultStyle();
    }

    public function __construct4($id, $name, $target_file, $style)
    {
        $this->id = $id;
        $this->name = $name;
        $this->target_file = $target_file;
        $this->makeType();
        $this->style = $style;
    }

    public static function initialiseID($id) {
        $layer = "";

        $result = self::find_by_sql("SELECT name, path, style FROM lmt_map.layer WHERE id = $id");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $layer = new Layer($id, $row["name"], $row["path"], $row["style"]);
        }

        return $layer;
    }

    public static function initialisePath($path) {
        $layer = new Layer();

        $layer->target_file = $path;

        $result = self::find_by_sql("SELECT id, name, style FROM lmt_map.layer WHERE path = $layer->target_file");
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $layer->name = $row["id"];
            $layer->name = $row["name"];
            $layer->style = $row["style"];

            $layer->makeType();
        }

        return $layer;
    }

    public function makeType() {
        $last_point = strrpos($this->target_file, ".");
        $this->type = substr($this->target_file, $last_point + 1);
    }

    public function print_table_row() {
        echo '<tr>';
        echo '<td>' . $this->name . '</td>';
        echo '<td>' . $this->style .'</td>';
        echo '<td class="actionsColumn">';
        echo '<button class="btn edit" id="' . $this->id .'" value="' . $this->id .'" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-square-o fa-lg green"></i></button>';
        echo '<button class="btn delete" id="' . $this->id .'" value="' . $this->id .'"><i class="fa fa-times fa-lg red" aria-hidden="true"></i></button>';
        echo '</td>';
    }

    public function getArray() {
        return array("id" => $this->id, "name" => $this->name, "style" => $this->style, "type" => $this->type);
    }

    public function setDefaultStyle() {
        $this->setCustomStyle("#dc143c", 2, "#ffa500", 4);
    }

    public function setCustomStyle($strokeColor, $strokeWidth, $circleColor, $circleRadius) {
        $style = array("stroke" => array("color" => $strokeColor, "width" => $strokeWidth), "circle" => array("radius" => $circleRadius, "fill" => array("color" => $circleColor)));

        $this->style = json_encode($style);
    }
}