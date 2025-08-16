<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Appointments</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php
    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }
    }else{
        header("location: ../login.php");
    }
    
    include("../connection.php");
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["docid"];
    $username=$userfetch["docname"];
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
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment menu-active">
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">My Patients</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="consultation.php" class="non-style-link-menu"><div><p class="menu-text">My Consultations</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="prescription.php" class="non-style-link-menu"><div><p class="menu-text">Prescriptions</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr>
                    <td width="13%" >
                    <a href="index.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">My Appointments</p>
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
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0">
                        <thead>
                        <tr>
                                <th class="table-headin">Patient Name</th>
                                <th class="table-headin">Requested Date</th>
                                <th class="table-headin">Confirmed Time</th>
                                <th class="table-headin">Status</th>
                                <th class="table-headin">Events</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                            <?php
                                $sqlmain = "SELECT * FROM appointment INNER JOIN patient ON appointment.pid = patient.pid WHERE docid = ? ORDER BY appodate DESC";
                                $stmt = $database->prepare($sqlmain);
                                $stmt->bind_param("i", $userid);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="5">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">You have no appointment requests.</p>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                }
                                else{
                                    while($row=$result->fetch_assoc()){
                                        $appoid=$row["appoid"];
                                        $pname=$row["pname"];
                                        $appodate=$row["appodate"];
                                        $appotime=$row["appotime"];
                                        $status=$row["status"];
                                        $status_text = "";
                                        $action_buttons = "";

                                        if($status == 0){
                                            $status_text = "<font color='blue'>Pending</font>";
                                            $action_buttons = '<a href="?action=accept&id='.$appoid.'" class="non-style-link"><button  class="btn-primary-soft btn"  style="padding: 8px 15px; margin: 5px;">Accept</font></button></a><a href="?action=reject&id='.$appoid.'" class="non-style-link"><button  class="btn-primary-soft btn"  style="padding: 8px 15px; margin: 5px; background-color: #fdd;">Reject</font></button></a>';
                                        }elseif($status == 1){
                                            $status_text = "<font color='green'>Accepted</font>";
                                            $action_buttons = "Confirmed";
                                        }elseif($status == 2){
                                            $status_text = "<font color='red'>Rejected</font>";
                                            $action_buttons = "Rejected";
                                        }

                                        echo '<tr>
                                            <td> &nbsp;'.substr($pname,0,35).'</td>
                                            <td style="text-align:center;">'.substr($appodate,0,10).'</td>
                                            <td style="text-align:center;">'.substr($appotime,0,5).'</td>
                                            <td style="text-align:center;">'.$status_text.'</td>
                                            <td>
                                            <div style="display:flex;justify-content: center;">
                                            '.$action_buttons.'
                                            </div>
                                            </td>
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
    <?php
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='accept'){
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>Accept Appointment</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            Please set a time for this appointment.
                            <form action="update-appointment-status.php" method="POST">
                                <input type="hidden" name="appoid" value="'.$id.'">
                                <input type="hidden" name="status" value="1">
                                <input type="time" name="appotime" class="input-text" required>
                                <br><br>
                                <input type="submit" class="login-btn btn-primary btn" value="Confirm">
                            </form>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
        }elseif($action=='reject'){
            $sql = "UPDATE appointment SET status = 2 WHERE appoid = ?";
            $stmt = $database->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            header("location: appointment.php");
        }
    }
    ?>
</body>
</html>
