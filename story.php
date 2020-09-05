<?php
require 'ConnectDatabase.php';


if(isset($_POST['publish'])){

    $title = $_POST['title'];
    $title = mysqli_real_escape_string($conn,$title);
    $title = htmlentities($title);

    $data = $_POST['post'];
    $data = mysqli_real_escape_string($conn,$data);
    $data = htmlentities($data);


    $sql = "INSERT INTO story (title,content) VALUE ('$title','$data')";
    $res = mysqli_query($conn,$sql);
    if($res){
        $_SESSION['message'] = "<div>Post is published</div>";
    }
    else{
        $_SESSION['message'] = "<div>Post is not published</div>";
        header("Location: story.php");

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story</title>
</head>
<body>
    <form action="story.php" method="POST" enctype="multipart/form-data">
        <textarea name="title" id="te" cols="30" rows="10" placeholder="Title"></textarea>
        <textarea name="post" id="tee" cols="30" rows="10"></textarea>
        <input type="submit" value="Publish" name="publish">
        <?php 
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }  ?>
    </form>
</body>
</html>