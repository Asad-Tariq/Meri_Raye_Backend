<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/Admin.php';
$review_id = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($admin->validate_params($_GET['review_id'])) {
        $review_id = $_GET['review_id'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Review ID is required!'));
        die();
    }

    if ($admin->delete_review($review_id)) {
        echo json_encode(array('success' => 1, 'message' => 'Review deleted successfully!'));
    } else {
        http_response_code(500);
        echo json_encode(array('success' => 0, 'message' => 'Internal Server Error!'));
    }
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
