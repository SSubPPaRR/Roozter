<?php
include 'db.php';
$sql = 'SELECT `Verified` FROM `admin` WHERE `Admin_ID` = "'.$_POST['AdminID'].'"';
echo $sql . '<br>';
if($result = mysqli_query($conn,$sql)){
    echo 'succsess:1';
    $row = mysqli_fetch_row($result);
    $newValue = ($row[0] == 0)? '1':'0';

    $sql='UPDATE `admin` SET `Verified`="'.$newValue.'" WHERE `Admin_ID` = "'.$_POST['AdminID'].'";';
    echo $sql . '<br>'; 

    if(mysqli_query($conn,$sql)){
        echo 'succsess:2';        
    } echo 'failed:2';

}else echo 'failed:1';
?>