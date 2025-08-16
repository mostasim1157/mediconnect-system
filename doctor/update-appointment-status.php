<?php
session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
        header("location: ../login.php");
    }
}else{
    header("location: ../login.php");
}

include("../connection.php");

if($_POST){
    $appoid = $_POST['appoid'];
    $status = $_POST['status'];
    $appotime = $_POST['appotime'];

    $sql = "UPDATE appointment SET status = ?, appotime = ? WHERE appoid = ?";
    $stmt = $database->prepare($sql);
    $stmt->bind_param("isi", $status, $appotime, $appoid);
    $stmt->execute();
    
    header("location: appointment.php");
}
?>
