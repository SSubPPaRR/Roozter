<?php
session_start();
include 'utilities/db.php';
?>
<!DOCTYPE html>
<html lang="en" id="bod">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="w3.css">
  <link rel="stylesheet" href="style.css">
  <script src="jquery.min.js"></script>
</head>
<script>

</script>
<style>
  html {
    overflow-y: hidden;
  }
  body,
  h1 {
    font-family: "Raleway", sans-serif
  }

  body,
  html {
    height: 100%;
    
  }

  .bgimg {
    background-image: url('images/forestbridge.jpg');
    min-height: 100%;
    background-position: center;
    background-size: cover;
  }
</style>

<body class="bgimg" onload="openFullscreen()">

  <!--schedule input-->


  <table id="schedule-table" class="w3-border w3-bordered w3-table w3-striped">
    <thead class="w3-blue schedule-header">
      <tr>
        <th>Date</th>
        <th>Start time</th>
        <th>End time</th>
        <th>Faculty</th>
        <th>Event</th>
        <th>Teacher</th>
        <th>Subject</th>
        <th>Classroom</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody id="schedule" class="schedule-body w3-white">
      <?php
      $today = date("Y-m-d");

      //$sql = 'SELECT ScheduleID FROM schedule WHERE Date = "' . $today . '"  ORDER BY `Start`';
      $sql = 'SELECT ScheduleID FROM schedule ORDER BY `Start`';
      $result = mysqli_query($conn, $sql);
      $schedule_list = array();

      while ($row = $result->fetch_assoc()) {
        $ScheduleID = $row['ScheduleID'];
        array_push($schedule_list, $ScheduleID);
      }
      if (sizeof($schedule_list) == 0) {
        echo '<tr><td colspan="11"><h1 class="w3-center"><u>There are no events</u></h1></td></tr>';
      }
      foreach ($schedule_list as $id) {

        $sql = 'SELECT `Date`,`Start`,`End`,`Faculty_Name`,`Event_Name`,`Teacher_Lastname`,`Subject_Name`,`Classroom_Name`,`Status`,`ScheduleID`,`Teacher_Firstname` FROM `schedule`,`classroom`,`event`,`teacher`,`subject`,`faculty` WHERE schedule.TeacherID = teacher.TeacherID AND schedule.ClassroomID = classroom.ClassroomID AND schedule.FacultyID = faculty.FacultyID AND schedule.EventID = event.EventID AND schedule.SubjectID = subject.SubjectID AND ScheduleID = ' . $id . ';';

        if ($result = mysqli_query($conn, $sql)) {
          if ($row = mysqli_fetch_row($result)) {
            $start = preg_replace('/:00(?!:00)/', '', '' . $row[1] . '');
            $end = preg_replace('/:00(?!:00)/', '', $row[2]);
            $status = ($row[8] == 0) ? '<span class="w3-text-green">Scheduled</span>' : '<span class="w3-text-red">Cancelled</span>';
            echo
              '<tr>
                                    <td class="col-date">' . $row[0] . '</td>
                                    <td class="col-start">' . $start . '</td>
                                    <td class="col-end">' . $end . '</td>
                                    <td class="col-fac">' . $row[3] . '</td>
                                    <td class="col-event">' . $row[4] . '</td>
                                    <td class="col-teach">' . $row[5] . '</td>
                                    <td class="col-subj">' . $row[6] . '</td>
                                    <td class="col-class">' . $row[7] . '</td>
                                    <td class="col-stat">' . $status . '</td>
                                </tr>';
          }
        }
      }
      ?>
    </tbody>
  </table>

</body>
<script>
  var elem = document.documentElement;

  function openFullscreen() {
    if (elem.requestFullscreen) {
      elem.requestFullscreen();
    } else if (elem.mozRequestFullScreen) {
      /* Firefox */
      elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullscreen) {
      /* Chrome, Safari & Opera */
      elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) {
      /* IE/Edge */
      elem.msRequestFullscreen();
    }

    $(document).ready(function() {

      
      function animate(){
      var limit = document.documentElement.scrollHeight - document.documentElement.offsetHeight;
      
        if ($("html").scrollTop() != limit) {
          $("html").animate({
            scrollTop: limit,
          }, 10000, "linear", function(){
            animate();
          });

        } else if($("html").scrollTop() >= (limit-1)){
          
          $("html").scrollTop(0);
          animate();
          
        }
      }
      animate();
      



    });
  }

</script>

</html>