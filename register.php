<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
<?php
$host = "127.0.0.1";
$user="root";
$pass ="123456789";
$database = "website";
$connect = mysqli_connect($host,$user,$pass,$database);
if(isset($_COOKIE['PHPSESSID'])){
    header("Location: /");
    die();
}
if(mysqli_connect_errno()){
    die("cannot connect ".mysqli_connect_error());
}
$username = $_POST['username'];// from user
$username = htmlentities($username,ENT_QUOTES);
$password = $_POST['password'];// from user
$ps2 = $_POST['password2'];// from user
$username = htmlentities($username,ENT_QUOTES);
$password = htmlentities($password,ENT_QUOTES);
$ps2 = htmlentities($ps2,ENT_QUOTES);
if(strlen($username) >0 and strlen($password) > 0 and strlen($ps2) > 0){
    if($password == $ps2){// i need to add limit to length password it need to be more than 8
        $password = sha1($password);
        $q = "select username from login where username='".$username."'";// sql injection
        $re = mysqli_query($connect,$q);
        $result = mysqli_fetch_assoc($re);
        if (isset($result['username'])) {
            echo 'the username is used';
        }
        else{// CREATE session 
            $date = time();
            $x = $username+$password+$date;
            $session = md5($x);
            $csrf = password_hash($session, PASSWORD_DEFAULT);
            $query = "insert into login(username,password,session,total,csrf_token)values('".$username."','".$password."','".$session."',0,'".$csrf."')";
            $execute = mysqli_query($connect,$query);
            $succss = "ok";
            setcookie('PHPSESSID',$session,[time()+3600*24*30,"/","localhost"]);
            header("Location: /");
        }
    }else{
        $er = 2;
    }
}
?>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="" method="post">
					<span class="login100-form-title">
						Member Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password2" name="password2" >
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
					<?php if($succss == 'ok'){echo "the registeration is succesfully.";} if($er == 2){echo "the password is not matching";}?>

					<div class="text-center p-t-136">
						
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>