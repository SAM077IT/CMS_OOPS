<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<!-- Navigation -->
    
<?php  include "includes/navigation.php"; ?>
<?php
require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

//$mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail ->isSMTP();
$mail ->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->Username = "samirul077islam@gmail.com";
$mail->Password = "rcozquxfmuwwjdrg";



if(isset($_POST['submit'])){
    $to = "samirul077islam@gmail.com";
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $e_body = $_POST['e_body'];

    if(!empty($email) && !empty($subject) && !empty($e_body)){
        $email = mysqli_real_escape_string($conn, $email);
        $subject = mysqli_real_escape_string($conn, $subject);
        $e_body = mysqli_real_escape_string($conn, $e_body);
        $e_body = wordwrap($e_body, 70);
        $name = "Sam";
        $header = "From:" . $email;
        $mail->setFrom($to, $name);
        $mail->addAddress($email, "sami");

        $mail->Subject = $subject;
        $mail->Body = $e_body;
        // //$bool = mail($to, $subject, $e_body);   

        $mail->send();

        // if(mail($to, $subject, $e_body, $header)){
        $message = "Your massage has been saved!! \n Thanks for contacting us.";
        //     //header("Location: thank_you.php"); 
        // }else{
        //     $message = "Contact failed";
        // }
    }
    else{
        $message = "Please fill up all the area!!";  
    }
}else{
    $message = "";
}
?> 
 
<!-- Page Content -->
<div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact Us</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off" onsubmit="user_added_alert()">
                    <h4><?php echo $message ?></h4>
                        
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" required>
                        </div>
                         <div class="form-group">
                            <label for="e_body" class="sr-only">Massage</label>
                            <textarea name="e_body" id="e_body" placeholder="Enter your massage here..." style="width: 554px; height: 43px;"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
<hr>

<!-- <script>
function user_added_alert() {
        alert ("Your massage successfully saved!");
               }
</script> -->

<?php include "includes/footer.php";?>
