<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/Review.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($review->validate_params($_POST['user_email'])) {
        $review->user_email = $_POST['user_email'];
    } else {
        echo json_encode("User Email is required!");
        die();
    }

    if ($review->validate_params($_POST['business_name'])) {
        $review->business_name = $_POST['business_name'];
    } else {
        echo json_encode("Business Name is required!");
        die();
    }

    if ($review->validate_params($_POST['title'])) {
        $review->title = $_POST['title'];
    } else {
        echo json_encode("Title is required!");
        die();
    }

    if ($review->validate_params($_POST['content'])) {
        $review->content = $_POST['content'];
    } else {
        echo json_encode("Content is required!");
        die();
    }

    if ($review->add_review()) {
        echo json_encode("Review successfully added!");
    } else {
        http_response_code(500);
        echo json_encode("Error");
    }
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
