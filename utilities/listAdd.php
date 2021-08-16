<?php
include 'db.php';

switch ($_POST['option']) {
        //teacher !
    case 1:
        $sql = 'INSERT INTO `teacher`( `Teacher_Lastname`, `Teacher_Firstname`, `FacultyID`) VALUES ("'.$_POST["lName"].'","'.$_POST["fName"].'","'.$_POST["fac"].'")';

        if (mysqli_query($conn, $sql)) {
            echo '<div id="add-teacher-failed-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
        }
        break;

        //classroom
    case 2:
        $sql = 'INSERT INTO `classroom`(`Classroom_Name`,`Capacity`) VALUES ("'.$_POST["name"].'","'.$_POST["cap"].'")';
        if (mysqli_query($conn, $sql)) {
            echo '<div id="add-x-failed-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
        }
        break;

        //subject   !
    case 3:
        $sql = 'INSERT INTO `subject`(`Subject_Name`, `FacultyID`) VALUES ("'.$_POST["name"].'",'.$_POST["fac"].')';

        if (mysqli_query($conn, $sql)) {
            echo '<div id="add-subject-failed-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
        }
        break;
        //event
    case 4:
        $sql = 'INSERT INTO `event`(`Event_Name`) VALUES ("'.$_POST["name"].'")';

        if (mysqli_query($conn, $sql)) {
            echo '<div id="add-x-failed-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
        }else echo mysqli_error($conn);
        break;
        //faculty
    case 5:
        $sql = 'INSERT INTO `faculty`(`Faculty_Name`) VALUES ("'.$_POST["name"].'")';

        if (mysqli_query($conn, $sql)) {
            echo '<div id="add-x-failed-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
        }
        break;
}
