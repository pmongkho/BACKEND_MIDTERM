<?php

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$category->id = $data->id;
$category->category = $data->category;

// Update category
if ($category->update()) {
    print json_encode(
        array('message' => 'Category Updated')
    );
} else {
    print json_encode(
        array('message' => 'Category not Updated')
    );
}