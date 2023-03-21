<?php

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instatitiate blog post object
$category = new Category($db);

// Get ID 
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get quote
$category->read_single();

// Create Array
$categoryArr = array(
    'id' => $category->id,
    'category' => $category->category
);

if (count($categoryArr) == 0) {
    print "category_id Not Found";
} else {
    // Convert to JSON
    print_r(json_encode($categoryArr));
}