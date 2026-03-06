<?php
$con = mysqli_connect("localhost","root","","crms");
if(!$con){
    die("Connection failed: ".mysqli_connect_error());
}
session_start();
?>
