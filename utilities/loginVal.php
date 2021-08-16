<?php
session_start();
include "db.php";
//message display
if($_POST['Submit'] == 0){
    $username = $_POST['Username'];
    $password = md5($_POST['Password']); 

    //admin login
    $sql='SELECT COUNT(*) FROM admin WHERE User_Name = "'.$username.'" AND Password = "'.$password.'"AND Verified = 0;';
    if($result = mysqli_query($conn, $sql)){
        $row = mysqli_fetch_row($result);
        if($row[0] == 1){
            //account not activated 

            echo '<label id="failed-login-msg" class=" w3-container w3-text-red w3-center" ><h5>Account has not been activated,<br> please contact admin.</h5></label>';                          

        }
        else{

            $sql='SELECT COUNT(*) FROM admin WHERE User_Name = "'.$username.'" AND Password = "'.$password.'"AND Verified = 1;';
            if($result = mysqli_query($conn, $sql)){
                $row = mysqli_fetch_row($result);
                if($row[0] > 0){

                    //login successfull 
                    echo '<label id="failed-login-msg" style="display: none;"></label>';   

                }else echo '<label id="failed-login-msg" class=" w3-container w3-text-red w3-center" ><h5>Incorrect username/password.</h5></label>';                          

            }

        }

    }//else echo "<div >"."Error: " . $sql . "<br>". mysqli_error($conn)."</div>";   
}
else{

    $username = $_POST['Username'];
    $password = md5($_POST['Password']); 

    //admin login
    $sql='SELECT COUNT(*) FROM admin WHERE User_Name = "'.$username.'" AND Password = "'.$password.'"AND Verified = 1;';
    if($result = mysqli_query($conn, $sql)){
        $row = mysqli_fetch_row($result);
        if($row[0] == 1){
            //login successfull 
            //setting userid and username for logged in pages(like profile)
            $sql = 'SELECT Admin_ID FROM admin WHERE User_Name = "'.$username.'"';
            if($result = mysqli_query($conn, $sql)){
                $row = mysqli_fetch_row($result);
                $_SESSION['loggedID']=$row[0];
                $_SESSION['loggedName']=$username;
                echo $row[0];

            }
        }
    }
}
mysqli_close($conn);     
?>