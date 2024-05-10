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
    protected static $db_table_fields = array('username', 'user_password', 'user_email');

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
        $sql_query = "SELECT * FROM users WHERE username = '{$username}' AND user_password = '{$password}' ";
        $the_result = self::find_query($sql_query);
        return !empty($the_result) ? array_shift($the_result) : false;
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
    public static function properties(){
        $properties = array();
        $object_properties = get_object_vars(new self);
        foreach(self::$db_table_fields as $db_fields){
            if(property_exists(new self, $db_fields)){
                $properties[$db_fields] = $db_fields;
            }
        }
        return $properties;
    }

    public function create(){
        global $my_db;
        $properties = self::properties();
        $sql = "INSERT INTO " . self::$db_table . "(" . implode(",", array_keys($properties)) . ")";
        $sql .=" VALUES ('". implode("','", array_values($properties)) ."')";

        if($my_db->query($sql)){
            //$this->user_id = $my_db->the_insert_id();
            return true;
        }else{
            return false;
        }
    }
}

$user = new user();