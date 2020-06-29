<?php


class File extends DatabaseObject
{
    public $temp_file, $target_file, $name, $type;

    public static function initialize_upload($upload_name) {
        if (!empty($_FILES)) {
            $file = new File();
            $file->temp_file = $_FILES[$upload_name]['tmp_name'];
            $file->target_file = str_replace('\\', '/',DATA . basename($_FILES[$upload_name]["name"]));
            $file->name = basename($_FILES[$upload_name]["name"]);
            $file->type = strtolower(pathinfo($file->target_file,PATHINFO_EXTENSION));

            return $file;
        } else {
            error("No file to upload");
        }
    }

    public function check() {
        if (file_exists($this->target_file))
            error("Sorry, file already exists. ");

        if ($this->type != "kml" && $this->type != "geojson")
            error("Sorry, only KML and GeoJson layers are allowed.");
    }

    public function upload() {
        if (!move_uploaded_file($this->temp_file, $this->target_file))
            error("Sorry, there was an error uploading your file.");
    }

    public static function delete($path) {
        echo unlink($path);
    }

    public static function rename($path, $new_path) {
        echo rename($path, $new_path);
    }
}