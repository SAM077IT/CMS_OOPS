<?php
class Session{

    private $signed_in = false;
    public $user_id;
    public $user_role;
    public $username;

    function __construct(){
        session_start();
        $this->check_the_login();
    }

    public function is_signed_in(){
        return $this->signed_in;
    }

    public function isAdmin(){
        return $this->user_role == "Admin" ? true : false;     
    }

    public function getUsername(){
        return $this->username;
    }

    public function login($user){
        if($user){
            $_SESSION['user_id'] = $user->user_id;
            $this->user_id = $_SESSION['user_id'];
            $_SESSION['user_role'] = $user->user_role;
            $this->user_role = $_SESSION['user_role'];
            $_SESSION['username'] = $user->username;
            $this->username = $_SESSION['username'];
            $this->signed_in = true;
        }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['user_role']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    private function check_the_login(){
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->user_role = $_SESSION['user_role'];
            $this->username = $_SESSION['username'];
            $this->signed_in = true;
        }else{
            unset($this->user_id);
            $this->signed_in = false;
        }
    }
}

$session = new Session();

?>