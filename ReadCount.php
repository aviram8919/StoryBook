<?php
require 'ConnectDatabase.php';
session_start();

if(!isset($_SESSION['username'])){
    echo "You are logged out";
    header('Location:login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>titlePage</title>
    <link rel="stylesheet" href="css/readcount.css">
</head>
<body>
<nav class="navbar navbar-light">
  <span class="navbar-brand mb-0 h1"> <a href="ReadCount.php">Hello! <?php echo $_SESSION['username'];   ?></a> </span>
  <span class="navbar-brand mb-0 h1"><a id="logout_link" href="logout.php">Logout</a></span>
</nav>
    <?php
    $sql = "SELECT * FROM story";
    $res = mysqli_query($conn,$sql);
    if(mysqli_num_rows($res)>0)
    {
        while($x=mysqli_fetch_assoc($res))
        {    
        ?>
        <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
            <span class="navbar-brand mb-0 h1"><a href="storypage.php?id=<?php echo $x['id'];?>"><?php echo $x['title'];?></a></span>
            <span class="navbar-brand mb-0 h1"><?php echo $x['views'];?> Read-Count</span>
        </nav>
    <?php
        }
    }
    else{
       echo "no post found";
    }

    ?>
</body>
</html>