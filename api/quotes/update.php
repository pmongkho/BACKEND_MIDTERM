<?php

include_once '../../config/Database.php';
include_once '../../models/quotes.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

// Update quote
if ($quote->update()) {
    print json_encode(
        array('message' => 'quote Updated')
    );
} else {
    print json_encode(
        array('message' => 'quote not Updated')
    );
}