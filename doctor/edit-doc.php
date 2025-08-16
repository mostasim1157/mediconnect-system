<?php
    
    include("../connection.php");

    if($_POST){
        $name=$_POST['name'];
        $oldemail=$_POST["oldemail"];
        $nid=$_POST['nid'];
        $spec=$_POST['spec'];
        $email=$_POST['email'];
        $tele=$_POST['Tele'];
        $url=$_POST['url'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];
        
        if ($password==$cpassword){
            $error='3';
            $result= $database->query("select doctor.docid from doctor inner join webuser on doctor.docemail=webuser.email where webuser.email='$email';");
            if($result->num_rows==1){
                $id2=$result->fetch_assoc()["docid"];
            }else{
                $id2=$id;
            }
            
            if($id2!=$id){
                $error='1';
                    
            }else{

                $sql1="update doctor set docemail='$email',docname='$name',docpassword='$password',docnid='$nid',doctel='$tele',specialties=$spec,docurl='$url' where docid=$id ;";
                $database->query($sql1);

                $sql1="update webuser set email='$email' where email='$oldemail' ;";
                $database->query($sql1);
                
                $error= '4';
                
            }
            
        }else{
            $error='2';
        }
    
    }else{
        $error='3';
    }
    

    header("location: settings.php?action=edit&error=".$error."&id=".$id);
?>
