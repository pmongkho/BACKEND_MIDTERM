<?php

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instatitiate blog post object
$quote = new Quote($db);

// Get ID 
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get quote
$quote->read_single();

// Create Array
$quoteArr = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author_id' => $quote->author_id,
    'category_id' => $quote->category_id

);

// Convert to JSON
print_r(json_encode($quoteArr));