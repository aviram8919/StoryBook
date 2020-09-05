<?php
require 'ConnectDatabase.php';

//adding new visitor
$visitor_ip = $_SERVER['REMOTE_ADDR'];

//TESTING
//$visitor_ip = "54:54:54";


//checking if visitor is unique
$query = "SELECT * FROM counter_table WHERE ip_address='$visitor_ip'";
$result = mysqli_query($conn,$query);

//check query error
if(!$result){
    die("retreiving query error<br>".$query);
}
$total_visitors = mysqli_num_rows($result);
if($total_visitors<1){
    $query = "INSERT INTO counter_table(ip_address) VALUES('$visitor_ip')";
    $result = mysqli_query($conn,$query);
}


//retreving existing user
$query = "SELECT * FROM counter_table";
$result = mysqli_query($conn,$query);

//check query error
if(!$result){
    die("retreiving query error<br>".$query);
}
$total_visitors = mysqli_num_rows($result);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Page</title>
    <style>
        
    </style>
</head>
<body>

<h1>Visitor Count</h1>
<h3><?php echo $total_visitors ?></h3>

<?php
$id = $_GET['id'];
$id = mysqli_real_escape_string($conn,$id);
$id = htmlentities($id);
$sql = "SELECT * FROM story where id=$id limit 1 ";
$res=mysqli_query($conn,$sql);
if(mysqli_num_rows($res)>0)
{
    $x = mysqli_fetch_assoc($res);
    echo $x['content'];
    $views=$x['views'];
    $sql = "UPDATE story set views=$views + 1  WHERE id=$id";
    $res=mysqli_query($conn,$sql);
}
else{
    header("Location: ReadCount.php");
}
?>
</body>
</html>