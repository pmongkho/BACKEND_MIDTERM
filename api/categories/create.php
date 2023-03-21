<?php error_reporting(0);

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if ($data->category) {
    $category->category = $data->category;
} else {
    print json_encode(array('message' => 'category_id Not Found'));
    die();
}

if ($category->create()) {
    $categoryItem = array(
        "id" => $category->id,
        "category" => $category->category
    );

    print json_encode($categoryItem);
} else {
    print json_encode(
        array('message' => 'Category not Created')
    );
}