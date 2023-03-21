<?php

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$category = new Category($db);

// Blog post query
$result = $category->read();

// get row count
$num = $result->rowCount();

// Check if any posts
if ($num > 0) {
    // post array
    $categoryArr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $categoryItem = array(
            'id' => $id,
            'category' => $category,

        );

        // push to data
        array_push($categoryArr, $categoryItem);
    }

    // Turn to JSON & output
    print json_encode($categoryArr);
} else {
    // no posts
    print json_encode(
        array('message' => 'No Category Found')
    );
}
?>