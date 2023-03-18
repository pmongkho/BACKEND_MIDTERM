<?php

include_once '../../config/Database.php';
include_once '../../models/Authors.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$author->id = $data->id;
$author->author = $data->author;

// Update Author
if ($author->update()) {
    print json_encode(
        array('message' => 'Author Updated')
    );
} else {
    print json_encode(
        array('message' => 'Author not Updated')
    );
}