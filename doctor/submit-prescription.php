<?php
    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }
    }else{
        header("location: ../login.php");
    }

    if($_POST){
        //import database
        include("../connection.php");
        
        $docid = $_POST["docid"];
        $pid = $_POST["pid"];
        $appoid = $_POST["appoid"];
        $presc_date = $_POST["presc_date"];
        $presc_details = $_POST["presc_details"];
        
        $sql="INSERT INTO prescription (docid, pid, appoid, presc_date, presc_details) VALUES (?, ?, ?, ?, ?)";
        $stmt = $database->prepare($sql);
        $stmt->bind_param("iiiss", $docid, $pid, $appoid, $presc_date, $presc_details);
        $stmt->execute();
        
        header("location: prescription.php");
    }
?>
