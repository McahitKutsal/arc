<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if($_SESSION["role"] !== "editor"){
    header("location: ../index.php");
    exit;
}
?>