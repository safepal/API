<!DOCTYPE html>

<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
	<!--<![endif]-->
	<!-- start: HEAD -->
	
<head>
		<title>SafePal</title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
		<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/plugins/animate.css/animate.min.css">
		<link rel="stylesheet" href="assets/plugins/iCheck/skins/all.css">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/styles-responsive.css">
		<link rel="stylesheet" href="assets/plugins/iCheck/skins/all.css">
		<!--[if IE 7]>
		<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome-ie7.min.css">
		<![endif]-->
		<!-- end: MAIN CSS -->
		<!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
		<!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
	</head>
	<!-- end: HEAD -->
	<!-- start: BODY -->
	<body class="login.box-register">
<?php
	require('db.php');
    // If form submitted, insert values into the database.
    if (isset($_POST['name'])){
        $name = $_POST['name'];
	    $email = $_POST['email'];
		$address = $_POST['address'];
        $password = $_POST['password'];
		$name = stripslashes($name);
		$name = mysql_real_escape_string($name);
		$email = stripslashes($email);
		$email = mysql_real_escape_string($email);
		$password = stripslashes($password);
		$password = mysql_real_escape_string($password);
		$address = stripslashes($address);
		$address = mysql_real_escape_string($address);
		$trn_date = date("Y-m-d H:i:s");
		
        $query = "INSERT into `ngo_user` (name, password, email, trn_date, address) VALUES ('$name', '".md5($password)."', '$email', '$trn_date', '$address')";
        $result = mysql_query($query);
        if($result){
            echo "<div class='form'><h3>You have registered successfully.</h3><br/>Click here to <a href='in.php'>return</a></div>";
        }
    }else{
?>

		<div class="row">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="logo">
					<img src="assets/images/logo.png">
				</div>
				
				<!-- start: REGISTER BOX -->
				<div class="box-register">
					<h3>Sign Up</h3>
					<p>
						Enter your personal details below:
					</p>
					<form class="form-register" name="registration" action="" method="post">
						<div class="errorHandler alert alert-danger no-display">
							<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
						</div>
						<fieldset>
							<div class="form-group">
								<input type="text" class="form-control" name="name" required placeholder="Full Name">
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="address" required placeholder="Address">
							</div>
							
							<p>
								Enter your account details below:
							</p>
							<div class="form-group">
								<span class="input-icon">
									<input type="email" class="form-control" name="email" required placeholder="Email">
									<i class="fa fa-envelope"></i> </span>
							</div>
							<div class="form-group">
								<span class="input-icon">
									<input type="password" class="form-control" required name="password" placeholder="Password">
									<i class="fa fa-lock"></i> </span>
							</div>
							<!--<div class="form-group">
								<span class="input-icon">
									<input type="password" class="form-control" name="password_again" placeholder="Password Again">
									<i class="fa fa-lock"></i> </span>
							</div>-->
							<div class="form-group">
								<div>
									<label for="agree" class="checkbox-inline">
										<input type="checkbox" class="grey agree" id="agree" name="agree">
										I agree to the Terms of Service and Privacy Policy
									</label>
								</div>
							</div>
							<div >
								<button type="submit" name="submit"  class="btn btn-green pull-right">
									Submit <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>
						</fieldset>
					</form>
					<!-- start: COPYRIGHT -->
					<div class="copyright">
						2016 &copy; SafePal.
					</div>
					<!-- end: COPYRIGHT -->
				</div>
				<!-- end: REGISTER BOX -->
			</div>
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<!--[if lt IE 9]>
		<script src="assets/plugins/respond.min.js"></script>
		<script src="assets/plugins/excanvas.min.js"></script>
		<script type="text/javascript" src="assets/plugins/jQuery/jquery-1.11.1.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
		<script src="assets/plugins/jQuery/jquery-2.1.1.min.js"></script>
		<!--<![endif]-->
		<script src="assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/iCheck/jquery.icheck.min.js"></script>
		<script src="assets/plugins/jquery.transit/jquery.transit.js"></script>
		<script src="assets/plugins/TouchSwipe/jquery.touchSwipe.min.js"></script>
		<script src="assets/js/main.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="assets/js/login.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>
        
<?php } ?>
	</body>
	<!-- end: BODY -->

</html>