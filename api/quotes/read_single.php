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
$result = $quote->read_single();

// Count rows
$num = $result->rowCount();

if ($num > 0) {
    // post array
    if ($num == 1) {
        $row = $result->fetch();
        extract($row);
        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category,
        );

        print_r(json_encode($quote_item));
    } else {
        $quotesArr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category,
            );

            // push to data
            array_push($quotesArr, $quote_item);
        }

        // Turn to JSON & output
        print json_encode($quotesArr);

    }

} else {
    // no posts
    print json_encode(
        array('message' => 'No Quotes found')
    );
}

// // Create Array
// $quoteArr = array(
//     'id' => $quote->id,
//     'quote' => $quote->quote,
//     'author' => $quote->author,
//     'category' => $quote->category

// );

// // Convert to JSON
// print_r(json_encode($quoteArr));