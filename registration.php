<?php  //include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<!-- Navigation -->
<?php checkIfUserIsLoggedInAndRedirect('/cms/admin'); ?>
<?php  include "includes/navigation.php"; ?>


<?php
$error = ['username' => '','email' => '','password' => ''];

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $username = escape($username);
    $email = escape($email);
    $password = escape($password);
    $user = new user();
    $user->username = $username;
    $user->user_email = $email;
    $user->user_password = $password;

    $user->create();

    if(strlen($username) < 4 ){
        $error['username'] = "Username needs to be more then 4 character long!";
    }elseif(userExists($username)){
        $error['username'] = "User already exists!";
    }
    if(emailExists($email)){
        $error['email'] = "Email already exists!";
    }
    if(strlen($password) < 4 ){
        $error['password'] = "Password needs to be more then 4 character long!";
    }

    foreach($error as $key => $value){
        if(empty($value)){
            unset($error[$key]);
        }
    }
    if(empty($error)){
        $password = password_hash("$password", PASSWORD_BCRYPT, ["cost" => 8]);

        $insert_query = "INSERT INTO users(username, user_email, user_password, user_role, reg_date) ";
        $insert_query .="VALUES('{$username}', '{$email}', '{$password}', 'Subscriber', now())";
        $register_user_query = mysqli_query($conn, $insert_query);
        confirmQuery($register_user_query);

        echo "<div class= text-center><h2>You are successfully registered! click <a href='index.php'>here</a> to login to CMS dashboard</h2></div>";
    }

    //header("Location: registration.php");
}
?> 
<!-- Page Content -->
<div class="container">
<a href=""></a>
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="on">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" required autocomplete = 'on'>
                            <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required>
                            <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password" required>
                            <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
<hr>
<script>
function user_added_alert() {
    // onsubmit="user_added_alert()"
        alert ("User successfully added!");
               }
</script>

<?php include "includes/footer.php";?>
