<?php


class File extends DatabaseObject
{
    public $temp_file, $target_file, $name, $type, $upload_name;

    public function check() {
        if (file_exists($this->target_file))
            error("Sorry, file already exists. ");

        if ($this->type != "kml" && $this->type != "geojson")
            error("Sorry, only KML and GeoJson layers are allowed.");
    }

    public function upload() {
        if (!empty($_FILES)) {
            $this->temp_file = $_FILES[$this->upload_name]['tmp_name'];
            $this->target_file = str_replace('\\', '/',DATA . basename($_FILES[$this->upload_name]["name"]));
            $this->name = basename($_FILES[$this->upload_name]["name"]);
            $this->type = strtolower(pathinfo($this->target_file,PATHINFO_EXTENSION));
        } else {
            error("No file to upload");
        }

        $this->check();

        if (!move_uploaded_file($this->temp_file, $this->target_file))
            error("Sorry, there was an error uploading your file.");
    }

    public function delete() {
        echo unlink($this->target_file);
    }
}