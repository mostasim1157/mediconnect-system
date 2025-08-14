<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">   
    <title>View Prescription</title>
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

    include("../connection.php");

    if($_GET){
        $id = $_GET['id'];
        $sqlmain = "SELECT p.*, d.docname, pt.pname FROM prescription p JOIN doctor d ON p.docid = d.docid JOIN patient pt ON p.pid = pt.pid WHERE p.presc_id = ?";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    }
    ?>
    <div id="popup1" class="overlay" style="visibility: visible; opacity: 1;">
        <div class="popup" style="width: 80%; max-width: 800px; animation: transitionIn-Y-bottom 0.5s;">
        <center>
            <a class="close" href="prescription.php">&times;</a>
            <div style="padding: 20px; text-align: left;">
                <h2 style="text-align: center;">Prescription Details</h2>
                <hr>
                <p><strong>Doctor:</strong> <?php echo $row['docname']; ?></p>
                <p><strong>Patient:</strong> <?php echo $row['pname']; ?></p>
                <p><strong>Date:</strong> <?php echo $row['presc_date']; ?></p>
                <hr>
                <p><strong>Prescription:</strong></p>
                <div style="border: 1px solid #eee; padding: 15px; border-radius: 5px; min-height: 200px; background-color: #f9f9f9;">
                    <?php echo nl2br($row['presc_details']); ?>
                </div>
            </div>
            <a href="prescription.php" class="non-style-link"><button class="btn-primary btn" style="margin: 10px;">Close</button></a>
        </center>
        </div>
    </div>
</body>
</html>