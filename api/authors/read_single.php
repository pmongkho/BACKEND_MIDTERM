<?php

include_once '../../config/Database.php';
include_once '../../models/Authors.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instatitiate blog post object
$author = new Author($db);

// Get ID 
$author->id = isset($_GET['id']) ? $_GET['id'] : die("category_id Not Found");

// Get quote
$author->read_single();

// Create Array
$authorArr = array(
    'id' => $author->id,
    'author' => $author->author
);
// Convert to JSON
print_r(json_encode($authorArr));

    
