<?php
include 'db.php';

switch ($_POST['option']) {
        //teacher
    case 0:
        $sql = 'SELECT `TeacherID`,`Teacher_Lastname`,`Teacher_Firstname` FROM `teacher` WHERE `FacultyID` = ' . $_POST['FacID'] . ' OR `FacultyID` = 6';
        $result = mysqli_query($conn, $sql);
        echo '<optgroup class="option-teacher">';
        echo '<option selected disabled>Pick a teacher</option>';
        while ($row = mysqli_fetch_row($result)) {
            echo '<option value="' . $row[0] . '">' . $row[1] . " " . $row[2] . '</option>';
        }
        echo '</optgroup>';
        break;

        //subject
    case 1:
        $sql = 'SELECT `SubjectID`,`Subject_Name` FROM `subject` WHERE `FacultyID`=' . $_POST['FacID'] . ' OR `FacultyID` = 6';
        $result = mysqli_query($conn, $sql);
        echo '<optgroup class="option-subject">';
        echo '<option selected disabled>Pick a subject</option>';
        while ($row = mysqli_fetch_row($result)) {
            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
        }
        echo '</optgroup>';
        break;

        //classroom
    case 3:
        //add classroom list
        if($_POST['option2'] == 0){
            $sql = 'SELECT * FROM `classroom` WHERE NOT `ClassroomID` IN (SELECT DISTINCT `ClassroomID` FROM `schedule` WHERE `Date` ="' . $_POST['Date'] . '" AND NOT (`End`<= "' . $_POST['Start'] . '" OR `Start`>= "' . $_POST['End'] . '"))';
        }else {
            //get orginal saved date
            $sql2= 'SELECT `Date` FROM schedule WHERE `ScheduleID` = "'.$_POST['scheduleID'].'"';
            $result = mysqli_query($conn, $sql2);
            if($row = mysqli_fetch_row($result)){
                $date=$row[0];

                //if new date the same as saved date show option in list
                if($date == $_POST['Date']){
                    $sql = 'SELECT * FROM `classroom` WHERE NOT `ClassroomID` IN (SELECT DISTINCT `ClassroomID` FROM `schedule` WHERE `Date` ="' . $_POST['Date'] . '" AND NOT (`End`<= "' . $_POST['Start'] . '" OR `Start`>= "' . $_POST['End'] . '" OR `ScheduleID` = "'.$_POST['scheduleID'].'"));';
                }
                else $sql = 'SELECT * FROM `classroom` WHERE NOT `ClassroomID` IN (SELECT DISTINCT `ClassroomID` FROM `schedule` WHERE `Date` ="' . $_POST['Date'] . '" AND NOT (`End`<= "' . $_POST['Start'] . '" OR `Start`>= "' . $_POST['End'] . '"))';

            }
        }
        $result = mysqli_query($conn, $sql);
            echo '<optgroup class="option-classroom">';
            echo '<option selected disabled>Pick a classroom</option>';
            while ($row = mysqli_fetch_row($result)) {
                echo '<option value="' . $row[0] . '" data-cap="' . $row[2] . '" style="display: block;">' . $row[1] . '</option>';
            }
            echo '</optgroup>';
            break;
    

        //add event
    case 2:
        if($_POST['multiWeek'] == 1){
            echo'<div id="failed-add-msg" class="w3-center" style="width: 100%;">';
            echo '<img style="width: 50px;" src="images\check-1.1s-128px.svg"><br>';
            echo '<textarea readonly style="min-width: 100%; max-width: 472px; min-height: 50px; max-height: 50px;">';
            
            for($date=date_create($_POST['DatID']); date_format($date,"Y-m-d") < $_POST['endDate']; date_add($date,date_interval_create_from_date_string("1 week"))){
                
                //check if already reserved
                $sql='SELECT COUNT(*) FROM `schedule` WHERE `Date` ="' . date_format($date,"Y-m-d") . '" AND `ClassroomID`="' . $_POST['ClassID'] . '" AND NOT (`End`<= "' . $_POST['Start'] . '" OR `Start`>= "' . $_POST['End'] . '");';
                
                if ($result=mysqli_query($conn, $sql)) {
                    $row = mysqli_fetch_row($result);
                    //if true then it doesn't exist already.
                    if($row[0] == 0){

                        //add to schedule
                        $sql = 'INSERT INTO `schedule`(`Start`, `End`, `TeacherID`, `ClassroomID`, `FacultyID`, `EventID`, `SubjectID`, `Status`, `Date`) VALUES("' . $_POST['Start'] . '","' . $_POST['End'] . '","' . $_POST['TeachID'] . '","' . $_POST['ClassID'] . '","' . $_POST['FacID'] . '","' . $_POST['EvID'] . '","' . $_POST['SubID'] . '","' . $_POST['StatID'] . '","' . date_format($date,"Y-m-d") . '")';
                        //echo $sql;
                        if (mysqli_query($conn, $sql)) {
                        }
                        else{
                            echo"\nA error has occured: failed to add lesson on date:" . date_format($date,"Y-m-d");
                        }
                    }
                    else{
                        echo"\nFailed to add lesson on date:" . date_format($date,"Y-m-d").", classroom already reserved.\n";
                    }
                }
                else{
                    echo'A query execution error has occured!(1)';
                    //echo mysqli_error($conn);
                }

            }

            //check if already reserved (end date)
            $sql='SELECT COUNT(*) FROM `schedule` WHERE `Date` ="' . date_format($date,"Y-m-d") . '" AND `ClassroomID`="' . $_POST['ClassID'] . '" AND NOT (`End`<= "' . $_POST['Start'] . '" OR `Start`>= "' . $_POST['End'] . '");';
            
            if ($result=mysqli_query($conn, $sql)) {
                $row = mysqli_fetch_row($result);
                //if true then it doesn't exist already.
                if($row[0] == 0){

                    $sql = 'INSERT INTO `schedule`(`Start`, `End`, `TeacherID`, `ClassroomID`, `FacultyID`, `EventID`, `SubjectID`, `Status`, `Date`) VALUES("' . $_POST['Start'] . '","' . $_POST['End'] . '","' . $_POST['TeachID'] . '","' . $_POST['ClassID'] . '","' . $_POST['FacID'] . '","' . $_POST['EvID'] . '","' . $_POST['SubID'] . '","' . $_POST['StatID'] . '","' . $_POST['endDate'] . '")';
                    if (mysqli_query($conn, $sql)) {
                    }
                    else{
                        echo"\nFailed to add lesson on date:" . $_POST['endDate'];
                    }

                }
                else{
                    echo"\nFailed to add lesson on date:" . date_format($date,"Y-m-d").", classroom already reserved.\n";
                }
            }
            else{
                echo'A query execution error has occured!(2)';
            }

            echo '</textarea>';
            echo'</div>';
        }
        else{
            $sql = 'INSERT INTO `schedule`(`Start`, `End`, `TeacherID`, `ClassroomID`, `FacultyID`, `EventID`, `SubjectID`, `Status`, `Date`) VALUES("' . $_POST['Start'] . '","' . $_POST['End'] . '","' . $_POST['TeachID'] . '","' . $_POST['ClassID'] . '","' . $_POST['FacID'] . '","' . $_POST['EvID'] . '","' . $_POST['SubID'] . '","' . $_POST['StatID'] . '","' . $_POST['DatID'] . '")';
            //echo $sql;
            if (mysqli_query($conn, $sql)) {
                echo '<div id="failed-add-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\check-1.1s-128px.svg"></div>';
            }  
        }
    break;   
}
