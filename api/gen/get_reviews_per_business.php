<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/Review.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($review->validate_params($_GET['business_id'])) {
        $review->business_id = $_GET['business_id'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Business ID is required!'));
        die();
    }

    echo json_encode(array('success' => 1, 'reviews' => $review->get_reviews_per_business()));
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
