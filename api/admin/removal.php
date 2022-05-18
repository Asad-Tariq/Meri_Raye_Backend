<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/Admin.php';
$entity_id = '';
$table_name = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($admin->validate_params($_GET['entity_id'])) {
        $entity_id = $_GET['entity_id'];
    } else {
        echo json_encode("Specify entity to delete!");
        die();
    }

    if ($admin->validate_params($_GET['table_name'])) {
        $table_name = $_GET['table_name'];
    } else {
        echo json_encode("Table name is required!");
        die();
    }

    if ($admin->delete($entity_id, $table_name)) {
        echo json_encode("Entity deleted successfully!");
    } else {
        http_response_code(500);
        echo json_encode("Internal Server Error!");
    }
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
