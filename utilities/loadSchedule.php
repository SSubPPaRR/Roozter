<?php
include 'db.php';

if(!isset($_POST['sql'])){
    
    $today = date("Y-m-d");
    $tomorrow  = new DateTime('tomorrow');
    $tomorrow  = $tomorrow->format('Y-m-d');

    if($_POST['totm'] == 0){
        $date = $_POST['date'];
    }
    else if($_POST['totm'] == 1){
        $date = $today;
    }else $date = $tomorrow;
}

    if(isset($_POST['sql'])){
        
        $sql = $_POST['sql'];
        
    } else $sql ='SELECT ScheduleID FROM schedule WHERE Date = "'.$date.'"  ORDER BY `Start`';

    $result= mysqli_query($conn,$sql);
    $schedule_list=array();

    while($row = $result->fetch_assoc()){
        $ScheduleID = $row['ScheduleID'];
        array_push($schedule_list,$ScheduleID);
    }

    if(sizeof($schedule_list) == 0){
        echo 
        '   <tbody id="schedule">
            <tr>
                <td colspan="11"><h1 class="w3-center"><u>There are no events</u></h1></td>
            </tr>
            </tbody>
        '
    ;
    }else{
    echo'<tbody id="schedule">';
    foreach( $schedule_list as $id ){

        $sql = 'SELECT `Date`,`Start`,`End`,`Faculty_Name`,`Event_Name`,`Teacher_Lastname`,`Subject_Name`,`Classroom_Name`,`Status`,`ScheduleID`,`Teacher_Firstname` FROM `schedule`,`classroom`,`event`,`teacher`,`subject`,`faculty` WHERE schedule.TeacherID = teacher.TeacherID AND schedule.ClassroomID = classroom.ClassroomID AND schedule.FacultyID = faculty.FacultyID AND schedule.EventID = event.EventID AND schedule.SubjectID = subject.SubjectID AND ScheduleID = '.$id.';';

        if ($result = mysqli_query($conn, $sql)) {
            if($row = mysqli_fetch_row($result)) {
                
                $start = preg_replace('/:00(?!:00)/','',''.$row[1].'');
                $end = preg_replace('/:00(?!:00)/','',$row[2]);
                $status = ($row[8]==0)? '<span class="w3-text-green">Scheduled</span>':'<span class="w3-text-red">Cancelled</span>';
                if($_POST['user']==0){
                    echo
                        '
                        <tr>
                            <td class="col-date">' . $row[0]. '</td>
                            <td class="col-start">' . $start . '</td>
                            <td class="col-end">' . $end. '</td>
                            <td class="col-fac">' . $row[3] . '</td>
                            <td class="col-event">' . $row[4] . '</td>
                            <td class="col-teach">' . $row[5] . '</td>
                            <td class="col-subj">' . $row[6] . '</td>
                            <td class="col-class">' . $row[7] . '</td>
                            <td class="col-stat">' . $status . '</td>
                            <td><span data-id="'.$row[9].'" data-teacher="'.$row[5]." ".$row[10].'" class="edit-event-btn w3-button w3-green"><i class="fas fa-edit"></i></span></td>
                            <td><span data-id="' . $row[9] . '" class="delete-event-btn w3-button w3-red"><i class="fas fa-trash"></i></span></td>
                        </tr>
                        ';  
                }else{
                    echo
                    '
                    <tr>
                        <td class="col-date">' . $row[0]. '</td>
                        <td class="col-start">' . $start . '</td>
                        <td class="col-end">' . $end. '</td>
                        <td class="col-fac">' . $row[3] . '</td>
                        <td class="col-event">' . $row[4] . '</td>
                        <td class="col-teach">' . $row[5] . '</td>
                        <td class="col-subj">' . $row[6] . '</td>
                        <td class="col-class">' . $row[7] . '</td>
                        <td class="col-stat">' . $status . '</td>
                    </tr>
                    ';  
                }
            } 
        }
    }
    echo'</tbody>';
}
?>