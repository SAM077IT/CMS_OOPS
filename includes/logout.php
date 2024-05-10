
<?php include "header.php"; ?>
<?php

    // $_SESSION['username'] = null;
    // $_SESSION['firstname'] = null;
    // $_SESSION['user_role'] = null;
    $session->logout();
    
    header("Location: ../index");

?>