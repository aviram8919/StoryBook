<?php
require 'ConnectDatabase.php';
session_start();


$error_array=array();

if(isset($_POST['login_button']))
{
    $email=filter_var($_POST['log_email'],FILTER_SANITIZE_EMAIL); //sanitize email

    $_SESSION['log_email']=$email; //store email into session variable
    $password= md5($_POST['log_password']); //get password

    $check_database_query= mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    $check_login_query= mysqli_num_rows($check_database_query);

    if($check_login_query==1)
    {
        $row=mysqli_fetch_array($check_database_query);
        $username=$row['username'];

        $_SESSION['username']=$username;
        header("Location: ReadCount.php");
        exit();
    }
    else{
        array_push($error_array, "Email or password was incorrect<br>");
    }

}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Log in</title>
<link rel="stylesheet" href="css/LoginCss.css">
</head>
<body>
<div class="loginBox">
    <img src="Avatar.jpg" class="user">
    <h2>LOG IN</h2>
    <form id="form" action="login.php" method="POST">
        <p>Email</p>
        <input type="email" name="log_email" placeholder=" Enter Email"  value="<?php 
  if(isset($_SESSION['log_email'])){
    echo $_SESSION['log_email'];
  } 
  ?>"required><br>
        <p>Password</p>
        <input type="password" name="log_password" placeholder="Password" required>
        <center><input style="width:50%;height:35px;" type="submit" name="login_button" value="Log In"></center><br>
        <p style="font-size:13px;">Not a User Yet?<a href="signup.php" title="Sign Up"> Join Now</a></p>

        
    </form>
<?php if(in_array("Email or password was incorrect<br>", $error_array)) echo "Email or password was incorrect"; ?>

</div>
</body>
</html>
