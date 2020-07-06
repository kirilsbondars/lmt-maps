<?php


class File
{
    public $temp_file, $target_file, $name, $type;

    public static function initialize_upload($upload_name) {
        if (!empty($_FILES)) {
            $file = new File();
            $file->temp_file = $_FILES[$upload_name]['tmp_name'];
            $file->name = basename($_FILES[$upload_name]["name"]);
            $file->type = strtolower(pathinfo(basename($_FILES[$upload_name]["name"]),PATHINFO_EXTENSION));
            $file->target_file = str_replace('\\', '/',DATA . generate_unique_filename(DATA) . "." . $file->type);

            return $file;
        } else {
            error("No file to upload");
        }
    }

    public function check() {
        if (file_exists($this->target_file))
            error("Sorry, file already exists. ");

        if ($this->type != "kml" && $this->type != "txt")
            error("Sorry, only KML and GeoJson layers are allowed.");
    }

    public function upload() {
        if (!move_uploaded_file($this->temp_file, $this->target_file))
            error("Sorry, there was an error uploading your file.");
    }

    public function delete() {
        return unlink($this->target_file);
    }

    public static function rename($path, $new_path) {
        return rename($path, $new_path);
    }

    public function covert_to_kml() {
        $new_path = str_replace('\\', '/',DATA . generate_unique_filename(DATA) . ".kml");

        if(!convert_to_kml($this->target_file, $new_path)) {
            $this->delete();
            error("Error converting");
        }

        $this->delete();

        $this->target_file = $new_path;
        $this->type = "kml";
    }
}