<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Dashboard</title>
    <style>
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-Y-bottom  0.5s;
        }
        .sub-table,.anime{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
    
    
</head>
<body>
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
    

    //import database
    include("../connection.php");
    $sqlmain= "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];

    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home menu-active" >
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="consultation.php" class="non-style-link-menu"><div><p class="menu-text">My Consultations</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="prescription.php" class="non-style-link-menu"><div><p class="menu-text">My Prescriptions</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
                        
                <tr >
                    
                    <td colspan="1" class="nav-bar" >
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">Home</p>
                          
                    </td>
                    <td width="25%">

                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                        date_default_timezone_set('Asia/Kolkata');

                        $today = date('Y-m-d');
                        echo $today;


                        $patientrow = $database->query("select  * from  patient;");
                        $doctorrow = $database->query("select  * from  doctor;");
                        $appointmentrow = $database->query("select  * from  appointment where pid='$userid';");

                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>


                </tr>
                <tr>

                <td colspan="4">
                        <center>
                        <table class="filter-container" style="border: none;width:95%" border="0" >
                        <tr>
                            <td >
                                <h3>Welcome!</h3>
                                <h1><?php echo $username  ?>.</h1>
                                <p>Find your doctor and book your appointment with ease.<br>
                                Your health is our priority. Let's get started!<br><br>
                                </p>
                                <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="width:30%">View All My Bookings</button></a>
                                <br>
                                <br>
                            </td>
                        </tr>
                        </table>
                        </center>
                    </td>
                </tr>
                <tr>

                    <td colspan="4" >
                        
                    <center>
                    <table class="filter-container" style="border: none;" border="0">
                        <tr>
                            <td colspan="4">
                                <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 33.33%;">
                                <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex">
                                    <div>
                                            <div class="h1-dashboard">
                                                <?php    echo $doctorrow->num_rows  ?>
                                            </div><br>
                                            <div class="h3-dashboard">
                                                All Doctors &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                    </div>
                                            <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/doctors-hover.svg');"></div>
                                </div>
                            </td>
                            <td style="width: 33.33%;">
                                <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                    <div>
                                            <div class="h1-dashboard">
                                                <?php    echo $patientrow->num_rows  ?>
                                            </div><br>
                                            <div class="h3-dashboard">
                                                All Patients &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                    </div>
                                            <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/patients-hover.svg');"></div>
                                </div>
                            </td>
                            <td style="width: 33.33%;">
                                <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex;padding-top:26px;padding-bottom:26px;">
                                    <div>
                                            <div class="h1-dashboard">
                                                <?php    echo $appointmentrow->num_rows  ?>
                                            </div><br>
                                            <div class="h3-dashboard" style="font-size: 15px">
                                                My Total Bookings
                                            </div>
                                    </div>
                                            <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/book-hover.svg');"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </center>
                    
                </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <p class="heading-main12" style="margin: 0;font-size:20px;padding: 10px;color:rgb(49, 49, 49);font-weight:600;text-align: left;">Your Recent Bookings</p>
                        <center>
                        <div class="abc scroll" style="height: 200px;margin-top: 20px;">
                        <table width="90%" class="sub-table scrolldown" border="0" >
                        <thead>
                        <tr>
                                <th class="table-headin">Doctor</th>
                                <th class="table-headin">Appointment Date</th>
                                <th class="table-headin">Appointment Time</th>
                                <th class="table-headin">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                            <?php
                            $sqlmain= "select * from appointment inner join doctor on doctor.docid=appointment.docid where pid=? and appodate>='$today' order by appodate asc";
                            $stmt = $database->prepare($sqlmain);
                            $stmt->bind_param("i", $userid);
                            $stmt->execute();
                            $result = $stmt->get_result();

                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">You have no upcoming appointments!</p>
                                    <a class="non-style-link" href="doctors.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Book an Appointment &nbsp;</font></button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $docname=$row["docname"];
                                    $appodate=$row["appodate"];
                                    $appotime=$row["appotime"];
                                    $status=$row["status"];
                                    $status_text = "";
                                    if($status == 0){
                                        $status_text = "<font color='blue'>Pending</font>";
                                    }elseif($status == 1){
                                        $status_text = "<font color='green'>Accepted</font>";
                                    }elseif($status == 2){
                                        $status_text = "<font color='red'>Rejected</font>";
                                    }
                                   
                                    echo '<tr>
                                        <td style="text-align:center;">'.substr($docname,0,20).'</td>
                                        <td style="text-align:center;">'.substr($appodate,0,10).'</td>
                                        <td style="text-align:center;">'.substr($appotime,0,5).'</td>
                                        <td style="text-align:center;">'.$status_text.'</td>
                                    </tr>';
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                        </div>
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
