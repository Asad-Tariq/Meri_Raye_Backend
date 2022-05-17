<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/Admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($admin->validate_params($_POST['email'])) {
        $admin->email = $_POST['email'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Email is required!'));
        die();
    }

    if ($admin->validate_params($_POST['password'])) {
        $admin->password = $_POST['password'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Password is required!'));
        die();
    }

    $s = $admin->login();
    if (gettype($s) === 'array') {
        http_response_code(200);
        // echo json_encode(array('success' => 1, 'message' => 'Login Successful!', 'user' => $s));
        echo json_encode("Success");
    } else {
        http_response_code(402);
        // echo json_encode(array('success' => 0, 'message' => $s));
        echo json_encode("Error");
    }
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
