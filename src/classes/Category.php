<?php


class Category extends DatabaseObject
{
    protected static string $table_name = "categories";
    protected static array $db_columns = ['id', 'name'];

    public $id, $name;

    public function __construct($args=[])
    {
        $this->name = $args['name'] ?? '';
    }

    protected function validate() {
        $this->errors = [];

        if(is_blank($this->name)) {
            $this->errors[] = "Name cannot be blank";
        }

        return $this->errors;
    }
}