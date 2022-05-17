<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-type, Accept'); // Handle pre-flight request

include_once '../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user->validate_params($_POST['name'])) {
        $user->name = $_POST['name'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Your name is required!'));
        die();
    }

    if ($user->validate_params($_POST['email'])) {
        $user->email = $_POST['email'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Email is required!'));
        die();
    }

    if ($user->validate_params($_POST['password'])) {
        $user->password = $_POST['password'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Password is required!'));
        die();
    }

    // // saving picture of user
    // $user_images_folder = '../../assets/user_images/';

    // if (!is_dir($user_images_folder)) {
    //     mkdir($user_images_folder);
    // }

    // if (isset($_FILES['image'])) {
    //     $file_name = $_FILES['image']['name'];
    //     $file_tmp = $_FILES['image']['tmp_name'];
    //     $extension = end(explode('.', $file_name));

    //     $new_file_name = $user->email . "_profile" . "." . $extension;

    //     move_uploaded_file($file_tmp, $user_images_folder . "/" . $new_file_name);

    //     $user->image = 'user_images/' . $new_file_name;
    // }

    if ($user->validate_params($_POST['description'])) {
        $user->description = $_POST['description'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Description is required!'));
        die();
    }

    if ($user->check_unique_email()) {
        if ($id = $user->register_user()) {
            echo json_encode("Success");
        } else {
            http_response_code(500);
            echo json_encode("Internal Server Error");
        }
    } else {
        http_response_code(401);
        echo json_encode("Email already exists!");
    }
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
