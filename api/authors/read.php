<?php

include_once '../../config/Database.php';
include_once '../../models/Authors.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$author = new Author($db);

// Blog post query
$result = $author ->read();

// get row count
$num = $result->rowCount();

// Check if any posts
if ($num > 0) {
    // post array
    $authorArr = array();
    $authorArr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $authorItem = array(
            'id' => $id,
            'author' => $author,

        );

        // push to data
        array_push($authorArr['data'], $authorItem);
    }

    // Turn to JSON & output
    print json_encode($authorArr);
} else {
    // no posts
    print json_encode(
        array('message' => 'No author found')
    );
}
?>