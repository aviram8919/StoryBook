<?php
require 'ConnectDatabase.php';
//declaring variables to prevent errors
$uname=""; //user name 
$em=""; //email
$em2="";
$password=""; //password
$password2=""; //password2
$date=""; //hlds sign up date
$error_array=array(); //holds error message

if(isset($_POST['register_button']))
{ 
  // Registration form values

  //user name
  $uname=strip_tags($_POST['reg_username']); //remove html tags
  $uname=str_replace(' ', '',$uname); //remove spaces
  $uname= ucfirst(strtolower($uname)); //uppercase first letter
  $_SESSION['reg_username']=$uname; //stores username in session variable

  //email
  $em=strip_tags($_POST['reg_email']); //remove html tags
  $em=str_replace(' ', '',$em); //remove spaces
  $em= ucfirst(strtolower($em)); //uppercase first letter
  $_SESSION['reg_email']=$em; //stores email in session variable

  //email2
  $em2=strip_tags($_POST['reg_email2']); //remove html tags
  $em2=str_replace(' ', '',$em2); //remove spaces
  $em2= ucfirst(strtolower($em2)); //uppercase first letter
  $_SESSION['reg_email2']=$em2;

  //password
  $password=strip_tags($_POST['reg_password']); //remove html tags
  $password2=strip_tags($_POST['reg_password2']); //remove html tags

  $date=date("Y-m-d"); //current date

  if($em == $em2){
    //check if email is in valid format

    if(filter_var($em, FILTER_VALIDATE_EMAIL)){
      $em=filter_var($em, FILTER_VALIDATE_EMAIL);

      //check if email already exist
      $e_check= mysqli_query($conn, "SELECT email FROM users WHERE email='$em'");

      //count the numbers of rows returned
      $num_rows= mysqli_num_rows($e_check);
      if($num_rows>0){
        array_push($error_array, "Email already in use<br>");
      }

    }
    else{
      array_push($error_array,"Invalid email Format<br>");
    }

  }
  else{
    array_push($error_array,"Emails don't match<br>");
  }

  //validation
  
  if(strlen($uname)>25 || strlen($uname)<4){
    array_push($error_array,"Your user name must be between 4 and 25 characters<br>");
  }

  if($password!=$password2){
    array_push($error_array,"Your passwords do not match<br>");
  }
  else{
    if(preg_match('/[^A-Za-z0-9]/', $password)){
      array_push($error_array,"Your password can only contain english letters or numbers<br>");
    }
  }

  if(strlen($password)>15 || strlen($password)<5){
    array_push($error_array,"Your password must be between 5 and 30 characters<br>");
  }

  if(empty($error_array)){
    $password=md5($password); //encrypt password before sending to the database

    //profile picture assignment
    $rand=rand(1,2);

    if($rand==1){
      $profile_pic="assets/images/profile_pic/default/Avatar.jpg";
    }
    else if($rand==2){
    $profile_pic="assets/images/profile_pic/default/Avatar1.jpg";
    }

    $query=mysqli_query($conn,"INSERT INTO users VALUES ('', '$uname', '$em', '$password', '$date')");

    array_push($error_array,"<span style='color: #14c800;'>Registration is successfully!! Go ahead and Login!!</span><br>");

    //clear session variable
    $_SESSION['reg_username']="";
    $_SESSION['reg_email']="";
    $_SESSION['reg_email2']="";

  }

}
?>
<!DOCTYPE html>
<html>
<head>
<title>Sign Up</title>
<link rel="stylesheet" type="text/css" href="css/SignUp_Css.css"></link>
</head>
<body>
<div class="signupbox">
<center>
<form class="fo" action="signup.php" method="POST">
  <h1 id="i1"><center> Sign Up</center></h1>
  <input class="input_box" type="text" name="reg_username" placeholder="Username" value="<?php if(isset($_SESSION['reg_username'])){   echo $_SESSION['reg_username'];} ?>"required><br><br>
  <?php if(in_array("Your user name must be between 4 and 25 characters<br>", $error_array)) echo "Your user name must be between 4 and 25 characters<br>"; ?>


  <input class="input_box" type="email" name="reg_email" placeholder="Email" value="<?php 
  if(isset($_SESSION['reg_email'])){
    echo $_SESSION['reg_email'];
  } 
  ?>"required><br><br>
  <input class="input_box" type="email" name="reg_email2" placeholder="Confirm Email" value="<?php 
  if(isset($_SESSION['reg_email2'])){
    echo $_SESSION['reg_email2'];
  } 
  ?>"required><br><br>

  <?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>";
   else if(in_array("Invalid email Format<br>", $error_array)) echo "Invalid email Format<br>";
   else if(in_array("Emails don't match<br>", $error_array)) echo "Emails don't match<br>"; ?>

  <input class="input_box"  type="password" name="reg_password" id="password" placeholder="Password" required><br><br>
  <input class="input_box" type="password" name="reg_password2" id="confirm" placeholder="Confirm Password" min="8" required><br><br>
  <?php if(in_array("Your passwords do not match<br>", $error_array)) echo "Your passwords do not match<br>";
   else if(in_array("Your password can only contain english letters or numbers<br>", $error_array)) echo "Your password can only contain english letters or numbers<br>";
   else if(in_array("Your password must be between 5 and 30 characters<br>", $error_array)) echo "Your password must be between 5 and 30 characters<br>"; ?>

<center style="padding-right:45px;">
  <input type="submit" name="register_button" value="Register"> &nbsp &nbsp
  <input type="reset" value="Reset">
</center>
<br>


<center style="padding-right:45px;"><p style="color:black"> Already Registered <white>||</white> <a href="login.php" title="Login"> Login</a>
</p></center>


 </form>
</center>
<?php if(in_array("<span style='color: #14c800;'>Registration is successfully!! Go ahead and Login!!</span><br>", $error_array)) header('Location:ReadCount.php'); ?>
</div>
</body>
</html>
