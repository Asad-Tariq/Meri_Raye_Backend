<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/Admin.php';
$name = '';
$email = '';
$password = '';
$image = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($admin->validate_params($_POST['name'])) {
        $name = $_POST['name'];
        $email = $name . '@meri_raye.com';
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Name is required!'));
        die();
    }

    if ($admin->validate_params($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Password is required!'));
        die();
    }

    // saving picture of admin
    $admin_images_folder = '../../assets/admin_images/';

    if (!is_dir($admin_images_folder)) {
        mkdir($admin_images_folder);
    }

    if (isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $extension = end(explode('.', $file_name));

        $new_file_name = $id . "__admin__" . $name . "." . $extension;

        move_uploaded_file($file_tmp, $admin_images_folder . "/" . $new_file_name);

        $image = 'admin_images/' . $new_file_name;
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Photo is required is required!'));
        die();
    }

    if ($admin->add_admin($name, $email, $password, $image)) {
        echo json_encode(array('success' => 1, 'message' => 'Admin successfully added!'));
    } else {
        http_response_code(500);
        echo json_encode(array('success' => 0, 'message' => 'Internal Server Error!'));
    }
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
