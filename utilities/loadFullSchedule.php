<?php
include 'db.php';
if($_POST['date']!=""){

    $date = $_POST['date'];
    $sql = 'SELECT ScheduleID FROM schedule WHERE Date = "' . $date . '"  ORDER BY `Start`';
    
}
else $sql = 'SELECT ScheduleID FROM schedule ORDER BY `Start`';


$result = mysqli_query($conn, $sql);
$schedule_list = array();

while ($row = $result->fetch_assoc()) {
    $ScheduleID = $row['ScheduleID'];
    array_push($schedule_list, $ScheduleID);
}

if (sizeof($schedule_list) == 0) {
    echo
        '   <tbody id="schedule">
            <tr>
               <td>No events.</td>
            </tr>
            </tbody>
        ';
} else {
    echo '<tbody id="schedule">';
    foreach ($schedule_list as $id) {

        $sql = 'SELECT `Date`,`Start`,`End`,`Faculty_Name`,`Event_Name`,`Teacher_Lastname`,`Subject_Name`,`Classroom_Name`,`Status`,`ScheduleID`,`Teacher_Firstname` FROM `schedule`,`classroom`,`event`,`teacher`,`subject`,`faculty` WHERE schedule.TeacherID = teacher.TeacherID AND schedule.ClassroomID = classroom.ClassroomID AND schedule.FacultyID = faculty.FacultyID AND schedule.EventID = event.EventID AND schedule.SubjectID = subject.SubjectID AND ScheduleID = ' . $id . ';';

        if ($result = mysqli_query($conn, $sql)) {
            if ($row = mysqli_fetch_row($result)) {

                $start = preg_replace('/:00(?!:00)/', '', '' . $row[1] . '');
                $end = preg_replace('/:00(?!:00)/', '', $row[2]);
                $status = ($row[8] == 0) ? '<span class="w3-text-green">Scheduled</span>' : '<span class="w3-text-red">Cancelled</span>';
                echo
                    '
                    <tr>
                        <td><input data-id="' . $row[9] . '" class="del-checkbx w3-input w3-large" type="checkbox"></td>
                        <td class="col-date">' . $row[0] . '</td>
                        <td class="col-start">' . $start . '</td>
                        <td class="col-end">' . $end . '</td>
                        <td class="col-fac">' . $row[3] . '</td>
                        <td class="col-event">' . $row[4] . '</td>
                        <td class="col-teach">' . $row[5] . '</td>
                        <td class="col-subj">' . $row[6] . '</td>
                        <td class="col-class">' . $row[7] . '</td>
                        <td class="col-stat">' . $status . '</td>
                        <td><span data-id="' . $row[9] . '" data-teacher="' . $row[5] . " " . $row[10] . '" class="edit-event-btn w3-button w3-green"><i class="fas fa-edit"></i></span></td>
                        <td><span data-id="' . $row[9] . '" class="delete-event-btn w3-button w3-red"><i class="fas fa-trash"></i></span></td>
                    </tr>
                    ';
            }
        }
    }
    echo '/<tbody>';
}
