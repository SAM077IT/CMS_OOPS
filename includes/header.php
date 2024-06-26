<?php include "init.php"?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Home</title>
    <script src="/cms_oops/js/jquery.js"></script>
    <!-- Bootstrap Core CSS -->
    <link href="/cms_oops/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/cms_oops/css/blog-home.css" rel="stylesheet">
    <link href="/cms_oops/css/styles.css" rel="stylesheet">
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">

    <link href="/cms_oops/admin/css/summernote.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css'>
    

    <script type = "text/javascript">
        function formValidation(){
            const nameOfAuthor = document.getElementById("nameOfAuthor").value;
            const emailOfAuthor = document.getElementById("emailOfAuthor").value;
            const commentContent = document.getElementById("commentContent").value;
            if (nameOfAuthor == "") {
                    window.alert("Please enter your name properly.");
                    return false;
            }
            if (emailOfAuthor == "") {
                    window.alert("Please enter your address.");
                    return false;
            }
            if (commentContent == "") {
                    window.alert("Please enter your Content.");
                    return false;
            }
        }
        // function comment_added_alert() {
        //     alert ("Comment successfully added!");        
        //     }  
    </script> 

    
</head>

