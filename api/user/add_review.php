<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/Review.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($review->validate_params($_POST['user_id'])) {
        $review->user_id = $_POST['user_id'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'User ID is required!'));
        die();
    }

    if ($review->validate_params($_POST['business_id'])) {
        $review->business_id = $_POST['business_id'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Business ID is required!'));
        die();
    }

    if ($review->validate_params($_POST['title'])) {
        $review->title = $_POST['title'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Title is required!'));
        die();
    }

    // saving picture of review
    $review_images_folder = '../../assets/review_images/';

    if (!is_dir($review_images_folder)) {
        mkdir($review_images_folder);
    }

    if (isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $extension = end(explode('.', $file_name));

        $new_file_name = $review->seller_id . "_review_" . $review->name . "." . $extension;

        move_uploaded_file($file_tmp, $review_images_folder . "/" . $new_file_name);

        $review->image = 'review_images/' . $new_file_name;
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Photo is required is required!'));
        die();
    }

    if ($review->validate_params($_POST['content'])) {
        $review->content = $_POST['content'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Content is required!'));
        die();
    }

    if ($review->add_review()) {
        echo json_encode(array('success' => 1, 'message' => 'Review successfully added!'));
    } else {
        http_response_code(500);
        echo json_encode(array('success' => 0, 'message' => 'Internal Server Error!'));
    }
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
