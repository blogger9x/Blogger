<?php 
$db = mysqli_connect('localhost','root','','english');
  if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
  }
?>