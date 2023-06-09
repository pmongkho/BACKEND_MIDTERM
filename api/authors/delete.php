<?php

include_once '../../config/Database.php';
include_once '../../models/Authors.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to delete
$author->id = $data->id;

// Delete Author
if ($author->delete()) {
    print json_encode(
        array('id' => $author->id)
    );
} else {
    print json_encode(
        array('message' => 'Author not Deleted')
    );
}