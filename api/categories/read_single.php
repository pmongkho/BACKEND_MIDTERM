<?php

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instatitiate blog post object
$category = new Category($db);


// Get ID 
$category->id = isset($_GET['id']) ? $_GET['id'] : die("");

// Get quote
$category->read_single();

if ($category->id != null) {

// Create Array
$categoryArr = array(
    'id' => $category->id,
    'category' => $category->category
);

// Convert to JSON
print_r(json_encode($categoryArr));
}else{
    // no posts
    print json_encode(
        array('message' => 'category_id Not Found')
    );
}


    
