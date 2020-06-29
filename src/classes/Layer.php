<?php
require_once("DatabaseObject.php");

class Layer extends DatabaseObject
{
    private $upload_name; //name used by form in html and used in $_FILES[""] to get file
    private $temp_file, $target_file;
    private $id, $name, $type;

    public function check() {
        if (file_exists($this->target_file))
            error("Sorry, file already exists. ");

        if ($this->type != "kml" && $this->type != "geojson")
            error("Sorry, only KML and GeoJson files are allowed.");
    }

    public function add_to_db() {
        self::run_sql("INSERT INTO lmt_map.layer(name, path, style) VALUES ('$this->name', '$this->target_file', 'hello')"); // no check
    }

    public function upload() {
        if (!move_uploaded_file($this->temp_file, $this->target_file))
            error("Sorry, there was an error uploading your file.");

        $this->add_to_db();
    }

    public function file($upload_name) {
        if (!empty($_FILES)) {
            $this->temp_file = $_FILES[$upload_name]['tmp_name'];
            $this->target_file = str_replace('\\', '/',DATA . basename($_FILES[$upload_name]["name"]));
            $this->name = basename($_FILES[$upload_name]["name"]);
            $this->type = strtolower(pathinfo($this->target_file,PATHINFO_EXTENSION));
        } else {
            error("No file to upload");
        }
    }

    public static function get_all() {
        $layers = array();

        $result = self::find_by_sql("SELECT id, name, style FROM lmt_map");
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                 array_merge($layers, $row);
            }
        }

        return $layers;
    }
}