<?php
session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
        header("location: ../login.php");
    }
}else{
    header("location: ../login.php");
}

require('fpdf.php'); // Make sure fpdf.php is in the same directory or provide the correct path

include("../connection.php");

if($_GET){
    $id = $_GET['id'];
    $sqlmain = "SELECT p.*, d.docname, pt.pname, pt.pemail, pt.ptel, d.docemail FROM prescription p JOIN doctor d ON p.docid = d.docid JOIN patient pt ON p.pid = pt.pid WHERE p.presc_id = ?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);

    // Header
    $pdf->Cell(0,10,'MediConnect - Medical Prescription',0,1,'C');
    $pdf->Ln(10);

    // Doctor and Patient Info
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(95,7,'Doctor Details',1,0,'C');
    $pdf->Cell(95,7,'Patient Details',1,1,'C');

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(95,7,'Name: '.$row['docname'],1,0);
    $pdf->Cell(95,7,'Name: '.$row['pname'],1,1);
    $pdf->Cell(95,7,'Email: '.$row['docemail'],1,0);
    $pdf->Cell(95,7,'Email: '.$row['pemail'],1,1);
    $pdf->Cell(95,7,'',1,0); // Empty cell for alignment
    $pdf->Cell(95,7,'Telephone: '.$row['ptel'],1,1);
    
    $pdf->Ln(10);

    // Prescription Details
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,7,'Prescription Date: '.$row['presc_date'],0,1);
    $pdf->Ln(5);

    $pdf->SetFont('Arial','',12);
    $pdf->MultiCell(0,10,$row['presc_details']);
    $pdf->Output('D','prescription-'.$id.'.pdf');
}
?>
