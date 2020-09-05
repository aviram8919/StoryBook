<?
$error_array=array();

if(isset($_POST['log_email']))
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
        header("Location: login.php");
        array_push($error_array, "Email or password was incorrect<br>");
        echo $error_array;
    }

}

?>