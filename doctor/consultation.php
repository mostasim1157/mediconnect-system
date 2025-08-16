<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Consultation</title>
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
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">My Patients</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord menu-active">
                        <a href="consultation.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">My Consultations</p></a></div>
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
                <tr >
                    <td width="13%" >
                    <a href="index.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">My Consultations</p>
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
                            <th class="table-headin">Appointment Date</th>
                            <th class="table-headin">Confirmed Time</th>
                            <th class="table-headin">Countdown</th>
                            <th class="table-headin">Connect</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                            <?php
                                $sqlmain = "SELECT * FROM appointment INNER JOIN patient ON appointment.pid = patient.pid WHERE docid = ? AND status = 1 ORDER BY appodate, appotime ASC";
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
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">You have no confirmed consultations.</p>
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
                                        $docurl=$userfetch["docurl"];
                                        $datetime_str = $appodate . " " . $appotime;
                                        echo '<tr id="row-'.$appoid.'">
                                            <td> &nbsp;'.substr($pname,0,35).'</td>
                                            <td style="text-align:center;">'.substr($appodate,0,10).'</td>
                                            <td style="text-align:center;">'.substr($appotime,0,5).'</td>
                                            <td style="text-align:center;" id="countdown-'.$appoid.'"></td>
                                            <td>
                                            <div style="display:flex;justify-content: center;">
                                            <a href="'.$docurl.'" target="_blank" id="connect-'.$appoid.'" class="non-style-link disabled-link"><button  class="btn-primary-soft btn"  style="padding: 8px 15px; margin: 5px;">Connect Now +</font></button></a>
                                            </div>
                                            </td>
                                        </tr>';
                                        
                                        echo '<script>
                                            var countDownDate'.$appoid.' = new Date("'.$datetime_str.'").getTime();
                                            var x'.$appoid.' = setInterval(function() {
                                                var now = new Date().getTime();
                                                var distance = countDownDate'.$appoid.' - now;
                                                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                                document.getElementById("countdown-'.$appoid.'").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                                                if (distance < 0) {
                                                    clearInterval(x'.$appoid.');
                                                    document.getElementById("countdown-'.$appoid.'").innerHTML = "EXPIRED";
                                                    document.getElementById("connect-'.$appoid.'").classList.remove("disabled-link");
                                                }
                                            }, 1000);
                                        </script>';
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