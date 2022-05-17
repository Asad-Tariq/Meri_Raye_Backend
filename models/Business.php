<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__). $ds . '..') . $ds;

require_once("{$base_dir}includes{$ds}Database.php"); // Including database

// Class Admin Start
class Business
{
    private $table = 'businesses';

    public $id;
    public $name;
    public $location;
    public $url;
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

    // saving new business in our database
    public function add_business()
    {
        global $database;

        $this->name = trim(htmlspecialchars(strip_tags($this->name)));
        $this->location = trim(htmlspecialchars(strip_tags($this->location)));
        $this->url = trim(htmlspecialchars(strip_tags($this->url)));
        $this->image = trim(htmlspecialchars(strip_tags($this->image)));

        $sql = "INSERT INTO $this->table (name, location, url, image) VALUES (
            '" .$database->escape_value($this->name). "',
            '" .$database->escape_value($this->location). "',
            '" .$this->url. "',
            '" .$database->escape_value($this->image). "'
        )";

        $admin_saved = $database->query($sql);

        if ($admin_saved) {
            return true;
        } else {
            return false;
        }
    }

} // Class Ends

// Business object
$business = new Business();