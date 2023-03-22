<?php error_reporting(0);

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate quote object
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

// Set ID to update
// $category->id = $data->id;
// $category->category = $data->category;

if ($data->category && $data->id) {
    $category->category = $data->category;
    $category->id = $data->id;

} else {
    print json_encode(array('message' => 'Missing Required Parameters'));
    die();
}

// Update category
if ($category->update()) {
    $categoryItem = array(
        "id" => $category->id,
        "category" => $category->category
    );

    print_r(json_encode($categoryItem));
} else {
    print json_encode(
        array('message' => 'Category not Updated')
    );
}