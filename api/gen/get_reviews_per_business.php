<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/Review.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($review->validate_params($_GET['business_name'])) {
        $review->business_name = $_GET['business_name'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Business name is required!'));
        die();
    }

    echo json_encode(array('success' => 1, 'reviews' => $review->get_reviews_per_business()));
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
