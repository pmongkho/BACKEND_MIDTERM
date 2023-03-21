<?php error_reporting(0);

include_once '../../config/Database.php';
include_once '../../models/Authors.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

if($data->author){
        $author->author = $data->author;
}else{
        print json_encode(array('message' => 'author_id Not Found'));
    die();
}

if ($author->create()) {

    $authorItem = array(
        "id" => $author->id,
        "author" => $author->author
    );

    print_r(json_encode($authorItem));
} else {
    print json_encode(
        array('message' => 'Author not Created')
    );
}