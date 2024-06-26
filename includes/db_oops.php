<?php
include_once("ConfigDB.php");

class Dbo extends ConfigDB{
    public $conn;
    function __construct(){
        $this->get_db_conn();
    }

    public function get_db_conn(){
        
        $this->conn = new mysqli(ConfigDB::DB_HOST, ConfigDB::DB_USER, ConfigDB::DB_PASS, ConfigDB::DB_NAME);

        if($this->conn->connect_errno){
            die("Database connection failed". $this->conn->mysqli_error);
        }
    }

    public function query($sql){
        $result = $this->conn->query($sql);
        $this->confirm_query($result);
        return $result;
    }

    private function confirm_query($result){
        if(!$result){
            die("Query Failed". $this->conn->error);
        }
    }

    public function escape_string($string){
        $escaped_string = $this->conn->real_escape_string($string);
        return $escaped_string;
    }

    public function recordCount($table){
        $select_all = $this->query("SELECT * FROM " . $table);
        return $select_all->num_rows;
    }

    function getPostLikes($post_id){
        $result = $this->query("SELECT * FROM likes WHERE post_id=$post_id");
        echo $result->num_rows;
    }

    function userLikedThisPost($post_id='', $user_id){
        $result = $this->query("SELECT * FROM likes WHERE user_id=$user_id AND post_id={$post_id}");
        return $result->num_rows >= 1 ? true : false;
    }
}

$my_db = new Dbo();

?>