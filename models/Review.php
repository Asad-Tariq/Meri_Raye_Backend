<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__). $ds . '..') . $ds;

require_once("{$base_dir}includes{$ds}Database.php"); // Including database

// class start
class Reviews
{
    private $table = 'reviews';

    public $id;
    public $user_id;
    public $title;
    public $image;
    public $content;
    public $likes;

    // contructor
    public function __construct()
    {
    }
 
    // validating if params exists or not
    public function validate_params($value)
    {
        return (!empty($value));
    }

    // storing review details
    public function add_review()
    {
        global $database;

        $this->user_id = trim(htmlspecialchars(strip_tags($this->user_id)));
        $this->title = trim(htmlspecialchars(strip_tags($this->title)));
        $this->image = trim(htmlspecialchars(strip_tags($this->image)));
        $this->content = trim(htmlspecialchars(strip_tags($this->content)));
        
        $sql = "INSERT INTO $this->table (user_id, title, image, content) VALUES (
            '" .$database->escape_value($this->user_id). "',
            '" .$database->escape_value($this->title). "',
            '" .$database->escape_value($this->image). "',
            '" .$database->escape_value($this->content). "'
            )";
            
        $result = $database->query($sql);
        
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    
    // method to return the list of reviews per user
    public function get_reviews_per_user()
    {
        global $database;
        
        $this->user_id = trim(htmlspecialchars(strip_tags($this->user_id)));

        $sql = "SELECT * FROM $this->table WHERE user_id = '" .$database->escape_value($this->user_id). "'";

        $result = $database->query($sql);

        return $database->fetch_array($result);
    }
} // class ends

// object
$review = new Reviews();
