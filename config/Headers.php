<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
exit();
}

switch ($method) {
    case "GET":
        if (!$_SERVER['QUERY_STRING']){
            include 'read.php';
            break;
        }else{
            include 'read_single';
            break;
        }

    case "POST":
        include 'create.php';
        break;
    case "PUT":
        include 'update.php';
        break;
    case "DELETE":
        include 'delete.php';
        break;
    default:
        print "";
}