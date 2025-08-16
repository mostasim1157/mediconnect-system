<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Doctor</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    
    include("../connection.php");



    if($_POST){
        $name=$_POST['name'];
        $nid=$_POST['nid'];
        $spec=$_POST['spec'];
        $email=$_POST['email'];
        $tele=$_POST['Tele'];
        $url=$_POST['url'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        
        if ($password==$cpassword){
            $error='3';
            
            $stmt_check = $database->prepare("select * from webuser where email=?");
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $result = $stmt_check->get_result();

            if($result->num_rows==1){
                $error='1';
            }else{
                $sql1="insert into doctor(docemail,docname,docpassword,docnid,doctel,specialties,docurl) values(?,?,?,?,?,?,?);";
                $stmt1 = $database->prepare($sql1);
                $stmt1->bind_param("sssssis", $email, $name, $password, $nid, $tele, $spec, $url);
                $stmt1->execute();
                
                if($stmt1->affected_rows == 1){
                    $sql2="insert into webuser values(?, 'd')";
                    $stmt2 = $database->prepare($sql2);
                    $stmt2->bind_param("s", $email);
                    $stmt2->execute();
                    $error= '4';
                } else {
                    $error = '5';
                }
            }
            
        }else{
            $error='2';
        }
    }else{
        $error='3';
    }
    

    header("location: doctors.php?action=add&error=".$error);
    ?>
</body>
</html>
