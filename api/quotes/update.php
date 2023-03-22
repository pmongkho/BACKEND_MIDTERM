<?php 

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';
include_once '../../models/Authors.php';
include_once '../../models/Categories.php';

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

//error handling
$author = new Author($db);
$author->id = $quote->author_id;

$category = new Category($db);
$category->id = $quote->category_id;

if ($quote->author_id) {
    $author->read_single();
    if ($author->id == null) {
        print json_encode(
            array('message' => 'author_id Not Found')
        );
        die();
    }
}

if ($quote->category_id) {
    $category->read_single();
    if ($category->id == null) {
        print json_encode(
            array('message' => 'category_id Not Found')
        );
        die();
    }
}

//Check to see pass test
if ($quote->quote) {
    // $quoteTemp = new Quote($db);
    // $quoteTemp = clone $quote;
    // $quoteTemp->find_quote();
    if ($quote->quote == null) {
        print json_encode(
            array('message' => 'No Quotes Found')
        );
        die();
    }
}

if (!$quote->id || !$quote->author_id || !$quote->category_id || !$quote->quote) {
    print json_encode(array('message' => 'Missing Required Parameters'));
    die();
}

// Update quote
if ($quote->update()) {

    $quoteItem = array(
        "id" => $quote->$id,
        "quote" => $quote->$quote,
        "author_id" => $quote->$author_id,
        "category_id" => $quote->$category_id
    );

    print_r(json_encode($quoteItem));
} else {
    print json_encode(
        array('message' => 'quote not Updated')
    );
}