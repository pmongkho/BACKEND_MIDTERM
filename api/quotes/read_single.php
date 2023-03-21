<?php

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instatitiate blog post object
$quote = new Quote($db);

// Get ID 
$quote->id = isset($_GET['id']) ? $_GET['id'] : null;
$quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
$quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// Get quote
$quote->read_single();

// Create Array
$quoteArr = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author' => $quote->author,
    'category' => $quote->category

);

// Convert to JSON
print_r(json_encode($quoteArr));