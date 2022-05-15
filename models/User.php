<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__). $ds . '..') . $ds;

require_once("{$base_dir}includes{$ds}Database.php"); // including the DB

class User {
    private $table = 'user';

    public $id;
    public $user_name;
    public $password;
    public $rating;
    public $following;
    public $followers;
    public $bio;
    public $image;

    // constructor
    public function __construct() {}

    // function to validate if params exist or not
    public function validate_params($value) {
        return (!empty($value));
    }

    // function to save new data in database
    public function register_user() {
        global $database;

        $this->user_name = trim(htmlspecialchars(strip_tags($this->user_name)));
        $this->password = trim(htmlspecialchars(strip_tags($this->password)));
        $this->rating = trim(htmlspecialchars(strip_tags($this->rating)));
        $this->following = trim(htmlspecialchars(strip_tags($this->following)));
        $this->followers = trim(htmlspecialchars(strip_tags($this->followers)));
        $this->bio = trim(htmlspecialchars(strip_tags($this->bio)));
        $this->image = trim(htmlspecialchars(strip_tags($this->image)));

        $sql = "INSERT INTO $this->table (user_name, password, rating, following, followers, bio, image) VALUES (
            '" .$database->escape_value($this->user_name). "',
            '" .$database->escape_value($this->password). "',
            '" .$database->escape_value($this->rating). "',
            '" .$database->escape_value($this->following). "',
            '" .$database->escape_value($this->followers). "',
            '" .$database->escape_value($this->bio). "',
            '" .$database->escape_value($this->image). "'
        )";

        $user_saved = $database->query($sql);

        if ($user_saved) {
            return true;
        } else {
            return false;
        }
    }
}

// User object
$user = new User();