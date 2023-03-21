<?php

include_once '../../config/Database.php';
include_once '../../models/Authors.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

$author->author = $data->author;

if ($author->create()) {
    $author->read_single();
} else {
    print json_encode(
        array('message' => 'Author not Created')
    );
}