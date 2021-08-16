<?php
include 'db.php';
switch($_POST["option"]){
    case 0: 
        $sql ='DELETE FROM `schedule` WHERE `ScheduleID` = "'.$_POST["SchedID"].'";';
        //echo $sql;
        if(mysqli_query($conn,$sql)){
            echo '<div id="confirmbox-btns" class="w3-center" style="width: 100%;"><img style="width: 100px;" src="images\check-1.1s-128px.svg"></div>';
        }
    break;

    case 1: 
        $sql ='DELETE FROM `schedule`';
        //echo $sql;
        if(mysqli_query($conn,$sql)){
            echo '<div id="confirmbox-btns2" class="w3-center" style="width: 100%;"><img style="width: 100px;" src="images\check-1.1s-128px.svg"></div>';
        }
    break;

    case 2: 
        $sql ='DELETE FROM `schedule` WHERE `ScheduleID` IN('.$_POST['Idlist'].');';
        //echo $sql;
        if(mysqli_query($conn,$sql)){
            echo '<div id="confirmbox-btns2" class="w3-center" style="width: 100%;"><img style="width: 100px;" src="images\check-1.1s-128px.svg"></div>';
        }
    break;
}



mysqli_close($conn);
?>