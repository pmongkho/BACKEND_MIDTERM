<?php error_reporting(0);

include_once '../../config/Database.php';
include_once '../../models/Authors.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

// Set ID to update
// $author->id = $data->id;
// $author->author = $data->author;

if ($data->author && $data->id) {
    $author->author = $data->author;
    $author->id = $data->id;
} else {
    print json_encode(array('message' => 'Missing Required Parameters'));
    die();
}

// Update Author
if ($author->update()) {
    $authorItem = array(
        "id" => $author->id,
        "author" => $author->author
    );

    print_r(json_encode($authorItem));
} else {
    print json_encode(
        array('message' => 'Author not Updated')
    );
}