<?php 

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quote = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to delete
$quote->id = $data->id;

$quoteTemp = clone $quote;

$quoteTemp->find_quote_id();

// Delete quote
if ($quote->delete() && $quoteTemp->id !=null) {

        print json_encode(
            array('id' => $quote->id)
        );

} else {
    print json_encode(
        array('message' => 'No Quotes Found')
    );
}