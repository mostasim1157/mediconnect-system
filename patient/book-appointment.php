<?php
session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }
}else{
    header("location: ../login.php");
}

include("../connection.php");

if($_POST){
    $docid = $_POST['docid'];
    $pid = $_POST['pid'];
    $appodate = $_POST['appodate'];

    $sql = "INSERT INTO appointment (pid, docid, appodate, status) VALUES (?, ?, ?, 0)";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("iis", $pid, $docid, $appodate);
    $stmt->execute();
    
    header("location: appointment.php");
}
?>
