<?php

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quote = new Quote($db);

// Blog post query
$result = $quote->read();

// get row count
$num = $result->rowCount();

// Check if any posts
if ($num > 0) {
    // post array
    $quotesArr = array();


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category'=> $category,
        );

        // push to data
        array_push($quotesArr, $quote_item);
    }

    // Turn to JSON & output
    print json_encode($quotesArr);
} else {
    // no posts
    print json_encode(
        array('message' => 'No Quotes Found')
    );
}
?>