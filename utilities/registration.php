<?php
include 'db.php';

$username = $_POST['username'];

$sql = 'SELECT COUNT(*) FROM admin WHERE User_Name = "'.$username.'"';

if($result = mysqli_query($conn, $sql)){
    $row = mysqli_fetch_row($result);
    if($row[0]>0){

        echo'<div id="Status-msg" data-type="0" class="w3-text-red w3-container">Username is already in use please try again';

    }
    else{

        $password = md5($_POST['password']);
            
        $sql='INSERT INTO admin (User_Name, Password,Verified) VALUES ("'.$username.'","'.$password.'","0")';

        if(mysqli_query($conn,$sql)){
            
            echo "<div id='Status-msg' data-type='1' class='w3-text-green w3-container'>Account has been created, please ask admin to activate account.</div>";
    
        }else echo "<div id='Status-msg' data-type='0' class='w3-text-red w3-container'> failed to send mail, try again.</div>";
    }
 
} 
 


?>