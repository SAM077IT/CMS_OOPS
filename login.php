<?php  //include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php

    // checkIfUserIsLoggedInAndRedirect('/cms/admin');
	// 	if(ifItIsMethod('post')){
	// 		if(isset($_POST['username']) && isset($_POST['password'])){
	// 			login_user($_POST['username'], $_POST['password']);
	// 		}else {
	// 			redirect('/cms/login.php');
	// 		}
	// 	}

	if($session->is_signed_in()){
		redirect("/cms_oops/admin/dashboard.php");
	}
	if(isset($_POST['login'])){
		$username = trim($_POST['username']);     
		$password = trim($_POST['password']);
	
		//check to database for the user
		$user_found = User::verify_user($username, $password);
		// echo "<br>";echo "<br>";echo "<br>";echo "<br>";
		// var_dump($user_found);
		// echo "<br>";
		// var_dump($user_found->username);
		// echo "<br>";
		// echo $user_found->user_role;
		if($user_found){
			$session->login($user_found);
			redirect("/cms_oops/admin/dashboard.php");
			
		}else{
			$the_message = "Username or Password is incorrect";
			header("Location: index.php");
		} 
	}else{
		$the_message = "";
		$username = "";
		$password = "";
	}
	
?>

<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

	<div class="form-gap"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-center">
							<h3><i class="fa fa-user fa-4x"></i></h3>
							<h2 class="text-center">Login</h2>
							<h4 class="bg-danger"><?php echo $the_message; ?></h4>
							<div class="panel-body">

								<form id="login-form" role="form" autocomplete="off" class="form" method="post">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

											<input name="username" type="text" class="form-control" placeholder="Enter Username" value = "<?php echo htmlentities($username)?>">
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
											<input name="password" type="password" class="form-control" placeholder="Enter Password">
										</div>
									</div>

									<div class="form-group">

										<input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
									</div>

								</form>

							</div><!-- Body-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<?php include "includes/footer.php";?>

</div> <!-- /.container -->
