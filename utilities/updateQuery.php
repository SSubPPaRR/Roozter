<?php
 include "db.php";
session_start();

if($_POST['option'] == 0 ){

  $sql= 'SELECT Password FROM admin WHERE Admin_ID = "'.$_SESSION['loggedID'].'"';

  if($result = mysqli_query($conn, $sql)){
    $row = mysqli_fetch_row($result);
    if ($row[0]== md5($_POST['oldPass'])){
        echo 1;
    } else echo 0;
  }
} else if ($_POST['option'] == 1 ){

  $sql = 'UPDATE admin SET Password="'.md5($_POST['newPass']).'" WHERE Admin_ID = "'.$_SESSION['loggedID'].'"';
  if($result = mysqli_query($conn, $sql)){

    echo '<span class="w3-text-green">Succesfully changed password.</span>';

  } else echo '<span class="w3-text-red">Password was not changed</span>';

}else if($_POST['option'] == 2){
  //check if password exists already.
  $sql ='SELECT * FROM `admin` WHERE `User_Name`= "'.$_POST['username'].'"';
  if(mysqli_num_rows(mysqli_query($conn, $sql)) == 1){
    echo '<span class="w3-text-red">Username already in use.</span>';
  }
  else{

    $sql = 'UPDATE admin SET User_Name="'.$_POST['username'].'" WHERE Admin_ID = "'.$_SESSION['loggedID'].'"';
    if($result = mysqli_query($conn, $sql)){
  
      echo '<span class="w3-text-green">Succesfully changed username.</span>';
      $_SESSION['loggedName'] = $_POST['username'];
  
    } else echo '<span class="w3-text-red">Username was not changed</span>';
  }
}


 ?>