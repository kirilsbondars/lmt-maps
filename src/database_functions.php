<?php
require_once ("db_credentials.php");

function db_connect() {
    $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS);
    confirm_db_connect($connection);
    mysqli_set_charset($connection, "utf8");
    //create_db($connection);
    mysqli_select_db($connection, DB_NAME);
    //create_tables($connection);
    return $connection;
}

function confirm_db_connect($connection) {
    if($connection->connect_errno) {
        $msg = "Database connection failed: ";
        $msg .= $connection->connect_error;
        $msg .= " (" . $connection->connect_errno . ")";
        exit($msg);
    }
}

function db_disconnect($connection) {
    if(isset($connection)) {
        $connection->close();
    }
}

function create_db($connection) {
    $query_db = "CREATE DATABASE IF NOT EXISTS " .DB_NAME. " CHARACTER SET utf8 COLLATE utf8_general_ci";
    return $connection->query($query_db);
}

function create_tables($connection) {
    $query_categories = "CREATE TABLE IF NOT EXISTS categories(";
    $query_categories .= "id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,";
    $query_categories .= "name tinytext NOT NULL)";
    $result_categories = $connection->query($query_categories);

    $query_input = "INSERT INTO categories (id, name) VALUES (";
    $query_input .= "'1', 'no category')";
    $result_input = $connection->query($query_input);

    $query_layers = "CREATE TABLE IF NOT EXISTS layers(";
    $query_layers .= "id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,";
    $query_layers .= "name tinytext NOT NULL,";
    $query_layers .= "path tinytext NOT NULL,";
    $query_layers .= "style JSON NOT NULL,";
    $query_layers .= "distance DECIMAL(10, 3) NOT NULL,";
    $query_layers .= "category INT NOT NULL,";
    $query_layers .= "FOREIGN KEY (category) REFERENCES categories(id))";
    $result_layers = $connection->query($query_layers);

    return $result_categories && $result_input && $result_layers;
}