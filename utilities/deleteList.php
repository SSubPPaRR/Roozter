<?php
    include 'db.php';
    switch ($_POST["option"]) {
        case 0:
            $sql = 'DELETE FROM `admin` WHERE `AdminID` = "' . $_POST["DelID"] . '";';
            //echo $sql;
            if (mysqli_query($conn, $sql)) {
                echo '<div id="confirmbox-btns" class="w3-center" style="width: 100%;"><img style="width: 100px;" src="images\check-1.1s-128px.svg"></div>';
            }
            break;
        case 1:
            $sql = 'DELETE FROM `teacher` WHERE `TeacherID` = "' . $_POST["DelID"] . '";';
            //echo $sql;
            if (mysqli_query($conn, $sql)) {
                echo '<div id="confirmbox-btns" class="w3-center" style="width: 100%;"><img style="width: 100px;" src="images\check-1.1s-128px.svg"></div>';
            }
            break;
        case 2:
            $sql = 'DELETE FROM `classroom` WHERE `ClassroomID` = "' . $_POST["DelID"] . '";';
            //echo $sql;
            if (mysqli_query($conn, $sql)) {
                echo '<div id="confirmbox-btns" class="w3-center" style="width: 100%;"><img style="width: 100px;" src="images\check-1.1s-128px.svg"></div>';
            }
            break;
        case 3:
            $sql = 'DELETE FROM `subject` WHERE `SubjectID` = "' . $_POST["DelID"] . '";';
            //echo $sql;
            if (mysqli_query($conn, $sql)) {
                echo '<div id="confirmbox-btns" class="w3-center" style="width: 100%;"><img style="width: 100px;" src="images\check-1.1s-128px.svg"></div>';
            }
            break;

        case 4:
            $sql = 'DELETE FROM `event` WHERE `EventID` = "' . $_POST["DelID"] . '";';
            //echo $sql;
            if (mysqli_query($conn, $sql)) {
                echo '<div id="confirmbox-btns" class="w3-center" style="width: 100%;"><img style="width: 100px;" src="images\check-1.1s-128px.svg"></div>';
            }
            break;
        case 5:
            $sql = 'DELETE FROM `faculty` WHERE `FacultyID` = "' . $_POST["DelID"] . '";';
            //echo $sql;
            if (mysqli_query($conn, $sql)) {
                echo '<div id="confirmbox-btns" class="w3-center" style="width: 100%;"><img style="width: 100px;" src="images\check-1.1s-128px.svg"></div>';
            }
            break;
    }
    mysqli_close($conn);
?>



