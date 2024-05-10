<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<body>
<?php
//phpinfo();

// $timeTarget = 0.02; // 50 milliseconds 

// $cost = 7;
// do {
//     $cost++;
//     $start = microtime(true);
//     password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
//     $end = microtime(true);
// } while (($end - $start) < $timeTarget);

// echo "Appropriate Cost Found: " . $cost;




?>

    <?php 
    echo LoggedInUserID();
    ?>

<h1>JavaScript String Methods</h1>
<h2>The link() Method</h2>

<p><a href="" onclick="user_alert();">Click me!!!</a></p>

<!-- <p>The link() method is deprecated in JavaScript.</p>
<p>Use an a tag instead:</p> -->

<!-- <p id="demo2"></p> -->

<script>
function user_alert(){
    let text = "Free Web Building Tutorials!";
    //let  result = link("https://www.w3schools.com");
    alert("Hey! you clicked me!! https://www.w3schools.com");
}


// result = "<a href='https://www.w3schools.com'>" + text + "</a>";
// document.getElementById("demo2").innerHTML = result;
</script>

</body>
</html>

<!-- <script>
      var a = document.createElement('a');
      var linkText = document.createTextNode("my title text");
      a.appendChild(linkText);
      a.title = "my title text";
      a.href = "http://example.com";
      document.body.appendChild(a);
</script> -->