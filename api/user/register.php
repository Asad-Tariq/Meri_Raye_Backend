<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept'); // used to handle pre-flight request

include_once '../../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user->validate_params($_POST['user_name'])) {
        $user->user_name = $_POST['user_name'];
    }  else {
        echo json_encode(array('success' => 0, 'message' => 'User name is required!'));
        die();
    }

    if ($user->validate_params($_POST['password'])) {
        $user->password = $_POST['password'];
    }  else {
        echo json_encode(array('success' => 0, 'message' => 'Password is required!'));
        die();
    }

    if ($user->validate_params($_POST['bio'])) {
        $user->bio = $_POST['bio'];
    }  else {
        echo json_encode(array('success' => 0, 'message' => 'Bio is required!'));
        die();
    }

    $user_images_folder = '../../assets/user_images';

    if (!is_dir($user_images_folder)) {
        mkdir($user_images_folder);
    }

    if (isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $extension = end(explode('.', $file_name));

        $new_file_name = $user->user_name . "_profile" . $extension;

        move_uploaded_file($file_tmp, $user_images_folder . "/" . $new_file_name);

        $user->image = 'user_images/' . $new_file_name;
    }

    if ($id = $user->register_user()) {
        echo json_encode(array('success' => 1, 'message' => 'User registered!'));
        die();
    } else {
        http_response_code(500);
        echo json_encode(array('success' => 0, 'message' => 'Internal Server Error!'));
    }

} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
