<?php
class user{
    public $user_id;
    public $username;
    public $user_password;
    public $firstname;
    public $lastname;
    public $user_email;
    public $user_role;
    protected static $db_table = "users";

    public static function find_query($sql){
        global $my_db;
        $result_set = $my_db->query($sql);
        $the_object_array = array();
        while($row = mysqli_fetch_array($result_set)){
            $the_object_array[] = self::instants($row);
        }

        return $the_object_array;
    }

    public static function find_all_users(){
        $result_set = self::find_query("SELECT * FROM USERS");
        return $result_set;
    }

    public static function find_user_by_id($id){
        $the_result = self::find_query("SELECT * FROM users where user_id = $id");
       return !empty($the_result) ? array_shift($the_result) : false;
        
    }

    public static function verify_user($username, $password){
        global $my_db;
        $username = $my_db->escape_string($username);
        $password = $my_db->escape_string($password);
        //AND user_password = '{$password}'
        $sql_query = "SELECT * FROM users WHERE username = '{$username}'";
        $the_result = self::find_query($sql_query);
        if(!empty($the_result)){
            $the_user_data = array_shift($the_result);
            if(password_verify($password,$the_user_data->user_password)){
                return $the_user_data;
            }
            else{
                return false;
            }
        }else{
            return false;
        }

    }

    public function update_user($id){
        global $my_db;
        $sql = "UPDATE users SET username= '" . $this->username ."', ";
        $sql .="user_password= '" . $this->user_password ."', ";
        $sql .="firstname= '" . $this->firstname ."', ";
        $sql .="lastname= '" . $this->lastname ."', ";
        $sql .="user_email= '" . $this->user_email ."', ";
        $sql .="user_role= '" . $this->user_role ."' ";
        $sql .=" WHERE user_id=$id";
        $my_db->query($sql);
        return (mysqli_affected_rows($my_db->conn) == 1 ? true : false);
    }

    private static function has_the_attribute($the_attribute){
        $object_properties = get_object_vars(new self);
        return array_key_exists($the_attribute, $object_properties);
    }

    public static function instants($the_record){
        $the_object = new self;
        foreach($the_record as $the_attribute => $value){
            if($the_object->has_the_attribute($the_attribute)){
                $the_object->$the_attribute = $value;
            }
        }
        return $the_object;
    }

    public function userExists($username){
        global $my_db;
        $result = $my_db->query("SELECT username FROM users WHERE username = '$username'");
        return $result->num_rows > 0 ? true : false;
    }

    public function emailExists($email){
        global $my_db;
        $result = $my_db->query("SELECT user_email FROM users WHERE user_email = '$email'");
        return $result->num_rows > 0 ? true : false;
    }

    public function create(){
        global $my_db;
        $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
        $query .= "VALUES('{$this->username}','{$this->user_email}', '{$this->user_password}', 'Subscriber' )";

        if($my_db->query($query)){
            //$this->user_id = $my_db->the_insert_id();
            return true;
        }else{
            return false;
        }
    }

    
}

$user = new user();