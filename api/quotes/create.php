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

$quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
$quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

if($quote->author_id==null){
    print json_encode(array('message' => 'author_id Not Found'));
}
if($quote->category_id==null){
    print json_encode(array('message' => 'category_id Not Found'));
}

if (!($quote->author_id || $quote->category_id || $quote->quote)){
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