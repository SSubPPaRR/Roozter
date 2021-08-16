<?php
session_start();
include 'db.php';

switch ($_POST['option']) {

        //admin
    case 0:
        $sql = 'SELECT Admin_ID FROM admin ORDER BY User_Name;';
        break;

        //teacher
    case 1:
        $sql = 'SELECT `TeacherID` FROM `teacher`ORDER BY Teacher_Firstname;';
        break;

        //classroom
    case 2:
        $sql = 'SELECT `ClassroomID` FROM `classroom`ORDER BY Classroom_Name;';
        break;

        //subject
    case 3:
        $sql = 'SELECT `SubjectID` FROM `subject`ORDER BY Subject_Name;';
        break;

    case 4:
        $sql = 'SELECT `EventID` FROM `event`ORDER BY Event_Name;';
        break;

    case 5:
        $sql = 'SELECT `FacultyID` FROM `faculty`ORDER BY Faculty_Name;';
        break;
}




$result = mysqli_query($conn, $sql);
$List_list = array();

while ($row = $result->fetch_row()) {
    $ListID = $row[0];
    array_push($List_list, $ListID);
}
if (sizeof($List_list) == 0) {
    echo '<tr><td colspan="11"><h1 class="w3-center"><u>There are no items</u></h1></td></tr>';
}
foreach ($List_list as $ListID) {

    switch ($_POST['option']) {

            //admin
        case 0:
            $sql = 'SELECT User_Name,Verified FROM admin WHERE Admin_ID= "' . $ListID . '";';

            if ($result = mysqli_query($conn, $sql)) {
                $row = mysqli_fetch_row($result);

                //place admin info in corresponding cells.
                echo '<tr><td>' . $row[0] . '</td>';

                //activate button
                echo'<td class="w3-center"><button data-id="' . $ListID . '" class="activate-event-btn w3-button w3-green"';
                echo ($ListID == $_SESSION['loggedID']) ? "disabled" : "";
                echo'>';
                echo ($row[1] == 0) ? '<i class="fas fa-unlock"></i>' : '<i class="fas fa-user-lock"></i>';
                echo'</button></td>';

                //delete button
                echo'<td class="w3-center"><button data-id="' . $ListID . '" class="delete-event-btn w3-button w3-red" ';
                echo ($ListID == $_SESSION['loggedID']) ? "disabled" : "";
                echo '><i class="fas fa-trash"></i></button></td></tr>';
            }
            break;

            //teacher
        case 1:
            $sql = 'SELECT `Teacher_Firstname`,`Teacher_Lastname`,`FacultyID` FROM `teacher` WHERE `TeacherID` = "' . $ListID . '";';
            if ($result = mysqli_query($conn, $sql)) {
                $row = mysqli_fetch_row($result);


                echo '<tr><td class="xname">' . $row[0] . " " . $row[1] . '</td><td class="w3-center"><button data-id="' . $ListID . '" data-fid="' . $row[2] . '" data-Fname="' . $row[0] . '" data-Lname="' . $row[1] . '" class="edit-event-btn w3-button w3-green"><i class="fas fa-edit"></i></button></td>';
                echo '<td class="w3-center"><button data-id="' . $ListID . '" class="delete-event-btn w3-button w3-red"><i class="fas fa-trash"></i></button></td></tr>';
            }
            break;

            //classroom
        case 2:
            $sql = 'SELECT `Classroom_Name`,`Capacity` FROM `classroom` WHERE `ClassroomID` = "' . $ListID . '";';
            if ($result = mysqli_query($conn, $sql)) {
                $row = mysqli_fetch_row($result);

                echo '<tr><td class="xname">'. $row[0] .'</td><td class="w3-center"><button data-id="' . $ListID . '" data-cap="' . $row[1] . '" class="edit-event-btn w3-button w3-green"><i class="fas fa-edit"></i></button></td>';
                echo '<td class="w3-center"><button data-id="' . $ListID . '" class="delete-event-btn w3-button w3-red"><i class="fas fa-trash"></i></button></td></tr>';
            }
            break;

            //subject
        case 3:
            $sql = 'SELECT `Subject_Name`,`FacultyID` FROM `subject` WHERE `SubjectID` = "' . $ListID . '";';
            if ($result = mysqli_query($conn, $sql)) {
                $row = mysqli_fetch_row($result);

                echo '<tr><td class="xname">'. $row[0] .'</td><td class="w3-center"><button data-id="' . $ListID . '" data-fid="' . $row[1] . '" class="edit-event-btn w3-button w3-green"><i class="fas fa-edit"></i></button></td>';
                echo '<td class="w3-center"><button data-id="' . $ListID . '" class="delete-event-btn w3-button w3-red"><i class="fas fa-trash"></i></button></td></tr>';
            }
            break;

        case 4:
            $sql = 'SELECT `Event_Name` FROM `event` WHERE `EventID` = "' . $ListID . '";';
            break;

        case 5:
            $sql = 'SELECT `Faculty_Name` FROM `faculty` WHERE `FacultyID` = "' . $ListID . '";';
            break;
    }


    if ($_POST['option'] > 1 && $_POST['option'] != 2 && $_POST['option'] != 3) {
        if ($result = mysqli_query($conn, $sql)) {
            $row = mysqli_fetch_row($result);

            //place admin info in corresponding cells.
            echo '<tr><td class="xname">' . $row[0] . '</td><td class="w3-center"><button data-id="' . $ListID . '" class="edit-event-btn w3-button w3-green" ';
            echo '><i class="fas fa-edit"></i></button></td>';
            echo '<td class="w3-center"><button data-id="' . $ListID . '" class="delete-event-btn w3-button w3-red"><i class="fas fa-trash"></i></button></td></tr>';
        }
    }
}
?>