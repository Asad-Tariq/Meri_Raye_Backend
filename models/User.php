<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__). $ds . '..') . $ds;

require_once("{$base_dir}includes{$ds}Database.php"); // Including database
require_once("{$base_dir}includes{$ds}Bcrypt.php"); // Including Bcrypt

// Class User Start
class User
{
    private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $password;
    public $image;
    public $address;
    public $description;

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
        $user_id = $database->fetch_row($result);

        return empty($user_id);
    }

    // saving new data in our database
    public function register_user()
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

        $user_saved = $database->query($sql);

        if ($user_saved) {
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
        $user = $database->fetch_row($result);

        if (empty($user)) {
            return "Incorrect credentials.";
        } else {
            if (Bcrypt::checkPassword($this->password, $user['password'])) {
                unset($user['password']);
                return $user;
            } else {
                return "Incorrect credentials.";
            }
        }
    }

    // method to return the list of users
    public function all_users() {
        global $database;

        $sql = "SELECT id, name, image, address FROM $this->table";

        $result = $database->query($sql);

        return $database->fetch_array($result);
    }
} // Class Ends

// User object
$user = new User();
