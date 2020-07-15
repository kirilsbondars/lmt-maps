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
    $query_layer =
        "CREATE TABLE IF NOT EXISTS layer(
        id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
        name tinytext NOT NULL,
        path tinytext NOT NULL,
        style JSON NOT NULL,
        distance INT NOT NULL)";
    return $connection->query($query_layer);
}