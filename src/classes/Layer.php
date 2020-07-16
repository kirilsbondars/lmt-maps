<?php


class Layer extends DatabaseObject
{
    // ----- START OF ACTIVE RECORD CODE ------
    protected static string $table_name = "layer";
    protected static array $db_columns = ['id', 'name', 'path', 'style', 'distance'];
    protected static array $colors = ['#FF6633', '#FF33FF', '#FFFF99', '#00B3E6',
        '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
        '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
        '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
        '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
        '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
        '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
        '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
        '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
        '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];

    public $id, $name, $path, $style, $type, $distance;

    public function __construct($args=[])
    {
        $this->name = $args['name'] ?? '';
        $this->path = $args['path'] ?? '';
        $this->style = $args['style'] ?? self::randomStyle();
        $this->distance = $args['distance'] ?? 0;
    }

    public function type() {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    public function full_name() {
        return $this->name . "." . $this->type();
    }

    public function uniqueRandomStyle() {

    }

    public function randomStyle() {
        $color = random_element_from_array(self::$colors);
        $stroke_width = 3;
        $circle_radius = 3;

        $style = '{"stroke":';
        $style .= '{"color":"' . $color .'","width":"' . $stroke_width . '"},';
        $style .= '"circle":';
        $style .= '{"radius":"' . $circle_radius .'","fill":{"color":"' . $color .'"}}}';

        return $style;
    }

    protected function validate() {
        $this->errors = [];

        if(is_blank($this->name)) {
            $this->errors[] = "Name cannot be blank";
        }
        if(is_blank($this->path)) {
            $this->errors[] = "Path cannot be blank";
        }
        if(is_blank($this->style)) {
            $this->errors[] = "Style cannot be blank";
        }
        if(is_blank($this->distance)) {
            $this->errors[] = "Distance cannot be blank";
        }
        if(!is_numeric($this->distance)) {
            $this->errors[] = "Distance need to be a number";
        }

        return $this->errors;
    }
}