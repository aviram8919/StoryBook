<?php
$db_name="storybook";  //the name of database you have created
$mysql_username="root";//The user name of server (see from privilages)
$mysql_password="1234";//Password of server
$server_name="localhost";//server name
$conn=mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name); //connection method
if(mysqli_connect_error())
{
    echo "Failed to connect: " . mysqli_connect_error();
}

?>
