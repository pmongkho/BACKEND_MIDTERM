<?php

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$category = new Category($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to delete
$category->id = $data->id;

// Delete category
if ($category->delete()) {
    print json_encode(
        array('message' => 'Category Deleted')
    );
} else {
    print json_encode(
        array('message' => 'Category not Deleted')
    );
}