<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__). $ds . '..') . $ds;

require_once("{$base_dir}includes{$ds}Database.php"); // Including database
require_once("{$base_dir}includes{$ds}Bcrypt.php"); // Including Bcrypt

// Class Admin Start
class Admin
{
    private $table = 'admins';

    public $id;
    public $name;
    public $email;
    public $password;
    public $image;

    // contructor
    public function __construct()
    {
    }

    // validating if params exists or not
    public function validate_params($value)
    {
        // print "value = " .$value;
        return (!empty($value));
    }

    // to check if email is unique or not
    public function check_unique_email()
    {
        global $database;

        $this->email = trim(htmlspecialchars(strip_tags($this->email)));

        $sql = "SELECT id FROM $this->table WHERE email = '" .$database->escape_value($this->email). "'";

        $result = $database->query($sql);
        $admin_id = $database->fetch_row($result);

        return empty($admin_id);
    }

    // saving new admin in our database
    public function register_admin()
    {
        global $database;

        $this->name = trim(htmlspecialchars(strip_tags($this->name)));
        $this->email = trim(htmlspecialchars(strip_tags($this->email)));
        $this->password = trim(htmlspecialchars(strip_tags($this->password)));
        $this->image = trim(htmlspecialchars(strip_tags($this->image)));
        $this->address = trim(htmlspecialchars(strip_tags($this->address)));
        $this->description = trim(htmlspecialchars(strip_tags($this->description)));

        $sql = "INSERT INTO $this->table (name, email, password, image, address, description) VALUES (
            '" .$database->escape_value($this->name). "',
            '" .$database->escape_value($this->email). "',
            '" .$database->escape_value(Bcrypt::hashPassword($this->password)). "',
            '" .$database->escape_value($this->image). "',
            '" .$database->escape_value($this->address). "',
            '" .$database->escape_value($this->description). "'
        )";

        $admin_saved = $database->query($sql);

        if ($admin_saved) {
            return true;
        } else {
            return false;
        }
    }

    // login function
    public function login()
    {
        global $database;

        $this->email = trim(htmlspecialchars(strip_tags($this->email)));
        $this->password = trim(htmlspecialchars(strip_tags($this->password)));

        $sql = "SELECT * FROM $this->table WHERE email = '" .$database->escape_value($this->email). "'";

        $result = $database->query($sql);
        $admin = $database->fetch_row($result);

        if (empty($admin)) {
            return "Incorrect credentials.";
        } else {
            if (Bcrypt::checkPassword($this->password, $admin['password'])) {
                unset($admin['password']);
                return $admin;
            } else {
                return "Incorrect credentials.";
            }
        }
    }

    // method to delete users
    public function delete_user($user_id) {
        global $database;

        $user_table = 'users';

        $sql = "DELETE FROM $user_table WHERE id = '" .$database->escape_value($user_id). "'";

        $result = $database->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // method to delete a review
    public function delete_review($review_id) {
        global $database;

        $reviews_table = 'reviews';

        $sql = "DELETE FROM $reviews_table WHERE id = '" .$database->escape_value($review_id). "'";

        $result = $database->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    // method to add admins
    public function add_admin($name, $email, $password, $image) {
        global $database;

        $name = trim(htmlspecialchars(strip_tags($name)));
        $email = trim(htmlspecialchars(strip_tags($email)));
        $password = trim(htmlspecialchars(strip_tags($password)));
        $image = trim(htmlspecialchars(strip_tags($image)));

        $sql = "INSERT INTO $this->table (name, email, password, image) VALUES (
            '" .$database->escape_value($name). "',
            '" .$database->escape_value($email). "',
            '" .$database->escape_value(Bcrypt::hashPassword($password)). "',
            '" .$database->escape_value($image). "'
        )";

        $admin_added = $database->query($sql);

        if ($admin_added) {
            return true;
        } else {
            return false;
        }
    }

} // Class Ends

// Admin object
$admin = new Admin();
