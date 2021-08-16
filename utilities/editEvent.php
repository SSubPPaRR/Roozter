<?php
include 'db.php';

switch ($_POST['option']) {
    //teacher(ingnore)
    case 0:
        $sql = 'SELECT `TeacherID`,`Teacher_Lastname`,`Teacher_Firstname` FROM `teacher` WHERE `FacultyID` = ' . $_POST['FacID'] . ' OR `FacultyID` = 6';

        $result = mysqli_query($conn, $sql);
        echo '<optgroup class="option-teacher">';
        echo '<option disabled>Pick a teacher</option>';
        while ($row = mysqli_fetch_row($result)) {
            echo '<option value="' . $row[0] . '">' . $row[1] . " " . $row[2] . '</option>';
        }
        echo '</optgroup>';
        break;

    //subject(ingnore)
    case 1:
        $sql = 'SELECT `SubjectID`,`Subject_Name` FROM `subject` WHERE `FacultyID`=' . $_POST['FacID'] . ' OR `FacultyID` = 6;';
        $result = mysqli_query($conn, $sql);
        echo '<optgroup class="option-subject">';
        echo '<option disabled>Pick a subject</option>';
        while ($row = mysqli_fetch_row($result)) {
            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
        }
        echo '</optgroup>';
        break;

    //edit event

    //schedule
    case 2:
        $sql = 'UPDATE `schedule` SET `ScheduleID`="' . $_POST['SchedID'] . '",`Start`="' . $_POST['Start'] . '",`End`="' . $_POST['End'] . '",`TeacherID`="' . $_POST['TeachID'] . '",`ClassroomID`="' . $_POST['ClassID'] . '",`FacultyID`="' . $_POST['FacID'] . '",`EventID`="' . $_POST['EvID'] . '",`SubjectID`="' . $_POST['SubID'] . '",`Status`="' . $_POST['StatID'] . '",`Date`="' . $_POST['DatID'] . '" WHERE `ScheduleID`="' . $_POST['SchedID'] . '";';
        //echo $sql;
        if (mysqli_query($conn, $sql)) {
            echo '<div id="failed-edit-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
        }
        break;

    //teacher
    case 3:
        $sql = 'UPDATE `teacher` SET `Teacher_Lastname`="' . $_POST['lName'] . '",`Teacher_Firstname`="' . $_POST['fName'] . '",`FacultyID`="' . $_POST['fac'] . '" WHERE `TeacherID`="' . $_POST['ID'] . '";';
        //echo $sql;
        if (mysqli_query($conn, $sql)) {
            echo '<div id="edit-teacher-failed-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
        }
        break;
    //classroom
    case 4:
        $sql = 'UPDATE `classroom` SET `Classroom_Name`="' . $_POST['xName'] . '",`Capacity`="' . $_POST['cap'] . '" WHERE `ClassroomID`="' . $_POST['ID'] . '";';
        //echo $sql;
        if (mysqli_query($conn, $sql)) {
            echo '<div id="edit-x-failed-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
        }
        break;
    
    //subject
    case 5: 
            $sql='UPDATE `subject` SET `Subject_Name`="'.$_POST['subjName'].'",`FacultyID`="'.$_POST['fac'].'" WHERE `SubjectID`="'.$_POST['ID'].'";';
            //echo $sql;
            if(mysqli_query($conn,$sql)){
                echo '<div id="edit-subject-failed-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
            }
        break;
    
    //event
    case 6: 
            $sql = 'UPDATE `event` SET `Event_Name`="' . $_POST['xName'] . '" WHERE `EventID`="' . $_POST['ID'] . '";';
            //echo $sql;
            if(mysqli_query($conn,$sql)){
                echo '<div id="edit-x-failed-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
            }
        break;
    //faculty    
    case 7: 
            $sql = 'UPDATE `faculty` SET `Faculty_Name`="' . $_POST['xName'] . '" WHERE `FacultyID`="' . $_POST['ID'] . '";';
            //echo $sql;
            if(mysqli_query($conn,$sql)){
                echo '<div id="edit-x-failed-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
            }
        break;
    }
?>