<?php

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->category = $data->category;

if ($category->create()) {
    // print json_encode(
    //     array('message' => 'Category Created')
    // );
    $category->read_single();
} else {
    print json_encode(
        array('message' => 'Category not Created')
    );
}