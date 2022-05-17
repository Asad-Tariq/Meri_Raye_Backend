<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/Business.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($business->validate_params($_POST['name'])) {
        $business->name = $_POST['name'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Name is required!'));
        die();
    }

    if ($business->validate_params($_POST['location'])) {
        $business->location = $_POST['location'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Location is required!'));
        die();
    }

    if ($business->validate_params($_POST['url'])) {
        $business->url = $_POST['url'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'URL is required!'));
        die();
    }

    // saving picture of business
    $business_images_folder = '../../assets/business_images/';

    if (!is_dir($business_images_folder)) {
        mkdir($business_images_folder);
    }

    if (isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $extension = end(explode('.', $file_name));

        $new_file_name = $business->seller_id . "_business_" . $business->name . "." . $extension;

        move_uploaded_file($file_tmp, $business_images_folder . "/" . $new_file_name);

        $business->image = 'business_images/' . $new_file_name;
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Photo is required is required!'));
        die();
    }

    if ($business->add_business()) {
        echo json_encode(array('success' => 1, 'message' => 'Business successfully added!'));
    } else {
        http_response_code(500);
        echo json_encode(array('success' => 0, 'message' => 'Internal Server Error!'));
    }
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
