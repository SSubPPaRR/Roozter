<?php
session_start();
include 'utilities/db.php';
include 'utilities/sesCheck.php';
?>
<!DOCTYPE html>
<html>
<title>Roozter</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Damion&display=swap">
<script src="https://kit.fontawesome.com/b7ab5ec9d0.js" crossorigin="anonymous"></script>
<script src="jquery.min.js"></script>
<script src="utilities\schedule.js"></script>
<script src="utilities\printThis-master\printThis.js"></script>

<style>
  body,
  h1 {
    font-family: "Raleway", sans-serif
  }

  body,
  html {
    height: 100%
  }

  .bgimg {
    background-image: url('images/forestbridge.jpg');
    min-height: 100%;
    background-position: center;
    background-size: cover;
  }

  .logo {
    font-family: 'Damion', cursive;
    text-decoration: none;
  }

  .main-panel {
    width: 90%;
    max-width: 1230px;
    min-width: 630px;
  }
</style>

<body class="bgimg">
  <div class="w3-center w3-black">Welcome,<?php echo $loggedName; ?></div>

  <div class="modal" style="display: block;">
    <a href="index.php" class="logo w3-display-position w3-padding-large w3-xlarge w3-border w3-margin w3-text-white" style="top: 10px;">Roozter</a>
    <a href="viewer.php" target="_blank" class="w3-display-position w3-padding-large w3-xlarge w3-border w3-margin w3-text-white w3-button" style="top: 10px;right: 0px;">Viewer</a>

    <div class="w3-display-middle main-panel">
      <!--menu-->
      <div class="w3-bar w3-black" style="padding: 8px 0 8px 0 ">
        <button id="today-btn" class="w3-bar-item w3-button" style="margin-left: 5px; background-color: grey;">Today</button>
        <button id="tommo-btn" class="w3-bar-item w3-button w3-hover">Tomorrow</button>
        <button id="sort-menu-btn" class="w3-bar-item w3-button w3-purple w3-round w3-right" style="margin-right: 5px;">Sort</button>
        <button id="print-btn" class="w3-bar-item w3-button w3-light-blue w3-round w3-right" style="margin-right: 5px;">Print</button>
        <input id="scheduleSearch" type="search" class="w3-bar-item w3-search w3-round w3-right" placeholder="Search..." style="margin-right: 5px;"></input>
      </div>

      <!--schedule input-->
      <div class="w3-white" style="overflow: scroll;">

        <table id="schedule-table" class="w3-border w3-bordered w3-table w3-hoverable w3-striped">
          <thead class="w3-blue">
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
          <tbody id="schedule">
            <?php
            $today = date("Y-m-d");

            $sql = 'SELECT ScheduleID FROM schedule WHERE Date = "' . $today . '"  ORDER BY `Start`';
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
        <?php
        $sql = 'SELECT `Start`,`End`,`Teacher_Lastname`,`Classroom_Name`,`Faculty_Name`,`Event_Name`,`Subject_Name`,`Status`,`Date` FROM `schedule`,`classroom`,`event`,`teacher`,`subject`,`faculty` WHERE schedule.TeacherID = teacher.TeacherID AND schedule.ClassroomID = classroom.ClassroomID AND schedule.FacultyID = faculty.FacultyID AND schedule.EventID = event.EventID AND schedule.SubjectID = subject.SubjectID;';
        if ($result = mysqli_query($conn, $sql)) {
          if (mysqli_num_rows($result) == 0) {
            echo '<h1 class="w3-center"><u>There are no events</u></h1>';
          }
        }
        ?>
      </div>
    </div>
  </div>

  <!--sort menu-->
  <div id="sort-menu" class="modal">
    <form id="sort-form" class="w3-display-middle w3-white w3-border w3-padding" action="schedule.php" method="POST">
      <span class="close-btn w3-button w3-display-topright w3-hover-red" title="Close Modal">&times;</span>


      <label for="Faculty"><b>Faculty</b></label>
      <select class="Faculty w3-input w3-border Sortinput" name="Faculty">
        <option value="" selected>None</option>
        <?php
        $sql = 'SELECT * FROM `faculty` WHERE NOT `Faculty_Name`="TEMP"';
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_row($result)) {
          echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
        }
        ?>
      </select>

      <label for="Teacher"><b>Teacher</b></label>
      <select class="Teacher w3-input w3-border Sortinput" name="Teacher">
        <option class="option-teacher" selected disabled>Please select a faculty first!</option>
        <option value="">None</option>
      </select>

      <label for="Subject"><b>Subject</b></label>
      <select class="Subject w3-input w3-border Sortinput" name="Subject">
        <option class="option-subject" selected disabled>Please select a faculty first!</option>
        <option value="">None</option>
      </select>

      <label class="col-lg-2 control-label">From</label><br>

      <input type="date" name="Start" id="from" class="From w3-input Sortinput"><br>


      <label for="End">To</label><br>

      <input type="date" name="End" id="to" class="To w3-input Sortinput"><br>

      <div style="display: inline-block;">
        <label for="Event"><b>Event</b></label>
        <select class="Event w3-input w3-border Sortinput" name="Event" >
          <option value="" selected>None</option>
          <?php
          $sql = 'SELECT * FROM `event`';
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_row($result)) {
            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
          }
          ?>
        </select>
      </div>

      <div style="display: inline-block;">
        <label for="Status"><b>Status</b></label>
        <select class="Status w3-input w3-border Sortinput" name="Status">
          <option value="">None</option>
          <option value="0">Scheduled</option>
          <option value="1">Cancelled</option>
        </select>
      </div>

      <button id="sort-btn" type="submit" class="w3-input w3-purple">Sort</button>
      <div id="failed-sort-msg"></div>
    </form>
  </div>
</body>

</html>