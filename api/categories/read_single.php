<?php

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instatitiate blog post object
$category = new Category($db);

if (isset($_GET['id'])) {
// Get ID 
$category->id = $_GET['id'];

// Get quote
$category->read_single();

// Create Array
$categoryArr = array(
    'id' => $category->id,
    'category' => $category->category
);

// Convert to JSON
print_r(json_encode($categoryArr));
    
} else {
    
    print "category_id Not Found";
}