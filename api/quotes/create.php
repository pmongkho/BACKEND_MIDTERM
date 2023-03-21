<?php error_reporting(0);

include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));

$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

if(!$quote->author_id){
    print json_encode(array('message' => 'author_id Not Found'));

}else if(!$quote->category_id){
    print json_encode(array('message' => 'category_id Not Found'));

}else if(!$quote->quote){
    print json_encode(array('message' => 'Missing Required Parameters'));
    die();
}

if($quote->create()){
    $quoteItem = array(
        "id" => $quote->id,
        "quote" => $quote->quote,
        "author_id"=> $quote->author_id,
        "category_id"=> $quote->category_id
    );

    print json_encode($quoteItem);

}else{
    print json_encode(
        array('message' => 'Quote not Created')
    );
}