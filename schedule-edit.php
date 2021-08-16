<?php
session_start();
include 'utilities/db.php';
include 'utilities/sesCheck.php';
if ($loggedID == "") {
    $url = "index.php";
    header("Location: $url");
}
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
<script src="utilities\event.js"></script>

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
        <a href="admin.php" class="w3-display-position w3-padding-large w3-xlarge w3-button w3-border w3-text-white w3-margin w3-hover-black w3-hover-border-deep-purple w3-hover-text-deep-purple w3-ripple" style="top: 10px; right:0;">Admin options</a>

        <div class="w3-display-middle main-panel">

            <!--menu-->
            <div class="w3-bar w3-black" style="padding: 8px 0 8px 0 ">
                <button id="today-btn" class="w3-bar-item w3-button" style="margin-left: 5px; background-color: grey;">Today</button>
                <button id="tommo-btn" class="w3-bar-item w3-button w3-hover">Tomorrow</button>
                <a target="_blank" href="full-schedule.php" class="w3-bar-item w3-button w3-purple w3-round w3-right" style="margin-right: 5px;">Full schedule</a>
                <button id="add-event-btn" class=" w3-bar-item w3-button w3-green w3-round w3-right" style="margin-right: 5px;">Add event</button>
                <input id="scheduleSearch" type="search" class="w3-bar-item w3-search w3-round w3-right" placeholder="Search..." style="margin-right: 5px;"></input>
            </div>

            <!--schedule input-->
            <div class="w3-white" style="overflow: scroll;">

                <table class="w3-table w3-hoverable w3-striped">
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
                            <th>Edit</th>
                            <th>Delete</th>
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
                                            <td><span data-id="' . $row[9] . '" data-teacher="' . $row[5] . " " . $row[10] . '" class="edit-event-btn w3-button w3-green"><i class="fas fa-edit"></i></span></td>
                                            <td><span data-id="' . $row[9] . '" class="delete-event-btn w3-button w3-red"><i class="fas fa-trash"></i></span></td>
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


    <!--Add event form-->
    <div id="add-event-form" class="modal">
        <form id="add-form" class="w3-display-middle w3-white w3-border w3-padding" style="max-height: 600px; overflow-y: scroll;" method="POST">
            <div class="w3-container w3-padding">
                <span id="add-event-close-btn" class="w3-button w3-display-topright w3-hover-red" title="Close Modal">&times;</span>

                <div style="display: inline-flex; width: 100%;">
                    <div style="width: 50%;">
                        <label for="Date"><b>Date</b></label>
                        <input type="date" class="Date w3-input w3-border" name="Date" placeholder="Enter Date" required>
                    </div>

                    <input id="End-check" type="checkbox" class="w3-check" style="width: 10%; margin-top: 6%;" title="Add lesson every week from start date to end date."></input>

                    <div style="width: 40%;">
                        <label for="EndDate"><b>End date</b></label>
                        <input id="endDate" type="date" class="w3-input w3-border" name="EndDate" placeholder="Enter End date" disabled>
                    </div>
                </div>


                <label for="Start"><b>Start</b></label>
                <input type="time" class="Start w3-input w3-border" name="Start" placeholder="Enter Starting time" required>

                <label for="End"><b>End</b></label>
                <input type="time" class="End w3-input w3-border" name="End" placeholder="Enter Ending time" required>



                <label for="Faculty"><b>Faculty</b></label>
                <select class="Faculty w3-input w3-border" name="Faculty" required>
                    <option selected disabled>Pick a faculty</option>
                    <?php
                    $sql = 'SELECT * FROM `faculty` WHERE NOT `Faculty_Name`="TEMP" AND NOT `Faculty_Name`="Algemeen"';
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_row($result)) {
                        echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                    ?>
                </select>

                <label for="Teacher"><b>Teacher</b></label>
                <select class="Teacher w3-input w3-border" name="Teacher" required>
                    <option class="option-teacher" disabled>Please select a faculty first!</option>
                </select>

                <label for="Subject"><b>Subject</b></label>
                <select class="Subject w3-input w3-border" name="Subject" required>
                    <option class="option-subject" disabled>Please select a faculty first!</option>
                </select>

                <label for="Classroom"><b>Classroom</b></label>

                <div style="display: flex;">
                    <select class="Classroom w3-input w3-border" name="Classroom" style="width: 80%" required>
                        <option class="option-classroom" disabled>Please select a date & time first!</option>
                    </select>

                    <div style="display: flex;">
                        <input id="capacity-check" type="checkbox" class="w3-check capacity-check" style="width: 50%; margin-top: 2%;" title="Enable classroom capacity filter."></input>

                        <input id="capFilter1" type="number" min="1" class="w3-input w3-border capacity-filter" style="width: 50%;" placeholder="Minimum capacity" title="Minimum capacity." disabled>
                    </div>
                </div>

                <div style="display: inline-block; width: 50%">
                    <label for="Event"><b>Event</b></label>
                    <select class="Event w3-input w3-border" name="Event" required>
                        <option selected disabled>Pick a event</option>
                        <?php
                        $sql = 'SELECT * FROM `event`';
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_row($result)) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div style="display: inline-block; width: 48%">
                    <label for="Status"><b>Status</b></label>
                    <select class="Status w3-input w3-border" name="Status" required>
                        <option value="0">Scheduled</option>
                        <option value="1">Cancelled</option>
                    </select>
                </div>

                <div id="failed-add-msg" class="w3-center" style="width: 100%;"></div>

                <button id="submit-event-btn" class="w3-button w3-green" style="width: 100%; margin-top: 10px;" type="submit">Add event</button>
            </div>
        </form>
    </div>

    <!--Edit event form-->
    <div id="edit-event-form" class="modal">
        <form id="edit-form" class="w3-display-middle w3-white w3-border w3-padding" style="max-height: 600px; overflow-y: scroll;" method="POST">
            <div class="w3-container w3-padding">
                <span id="edit-event-close-btn" class="w3-button w3-display-topright w3-hover-red" title="Close Modal">&times;</span>

                <label for="Date"><b>Date</b></label>
                <input type="date" class="Date w3-input w3-border" name="Date" placeholder="Enter Date" required>

                <label for="Start"><b>Start</b></label>
                <input type="time" class="Start w3-input w3-border" name="Start" placeholder="Enter Starting time" required>

                <label for="End"><b>End</b></label>
                <input type="time" class="End w3-input w3-border" name="End" placeholder="Enter Ending time" required>



                <label for="Faculty"><b>Faculty</b></label>
                <select class="Faculty w3-input w3-border" name="Faculty" required>
                    <option disabled>Pick a faculty</option>
                    <?php
                    $sql = 'SELECT * FROM `faculty` WHERE NOT `Faculty_Name`="TEMP" AND NOT `Faculty_Name`="Algemeen"';
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_row($result)) {
                        echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                    ?>
                </select>

                <label for="Teacher"><b>Teacher</b></label>
                <select class="Teacher w3-input w3-border" name="Teacher" required>
                    <option class="option-teacher" disabled>Pick a teacher</option>
                </select>

                <label for="Subject"><b>Subject</b></label>
                <select class="Subject w3-input w3-border" name="Subject" required>
                    <option class="option-subject" disabled>Pick a subject</option>
                </select>

                <label for="Classroom"><b>Classroom</b></label>
                <div style="display: flex;">
                    <select class="Classroom w3-input w3-border" name="Classroom" required>
                        <?php
                        $sql = 'SELECT * FROM `classroom`';
                        $result = mysqli_query($conn, $sql);
                        echo '<optgroup class="option-classroom">';
                        echo '<option selected disabled>Pick a classroom</option>';
                        while ($row = mysqli_fetch_row($result)) {
                            echo '<option value="' . $row[0] . '" data-cap="' . $row[2] . '">' . $row[1] . '</option>';
                        }
                        echo '</optgroup>';
                        ?>
                    </select>

                    <div style="display: flex;">
                        <input  type="checkbox" class="w3-check capacity-check" style="width: 50%; margin-top: 2%;" title="Enable classroom capacity filter."></input>

                        <input id="capFilter2" type="number" min="1" class="w3-input w3-border capacity-filter" style="width: 50%;" placeholder="Minimum capacity" title="Minimum capacity." disabled>
                    </div>
                </div>
                <div style="display: inline-block;">
                    <label for="Event"><b>Event</b></label>
                    <select class="Event w3-input w3-border" name="Event" required>
                        <option selected disabled>Pick a event</option>
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
                    <select class="Status w3-input w3-border" name="Status" required>
                        <option value="0">Scheduled</option>
                        <option value="1">Cancelled</option>
                    </select>
                </div>

                <input id="scheduleID" type="hidden">

                <div id="failed-edit-msg" class="w3-center" style="width: 100%;"></div>

                <button id="submit-event-btn2" class="w3-button w3-green" style="width: 100%; margin-top: 10px;" type="submit">Save changes</button>
            </div>
        </form>
    </div>

    <!--confirmation box-->
    <div id="delete-confirmbox" class="modal">
        <form id="confirm-form" class="w3-white w3-display-middle w3-xlarge w3-card-4">
            <span onclick="document.getElementById('delete-confirmbox').style.display='none',document.getElementById('confirm-form').reset();" class="w3-button w3-display-topright" style="width: 52px;" title="Close Modal">&times;</span>
            <div class="w3-container w3-padding w3-center">
                <h1>Delete Event</h1>
                <p>Are you sure you want to delete event from schedule?</p>

                <input id="delete-id" type="hidden">
                <div id="confirmbox-btns">
                    <button type="button" class="cancel-btn w3-button w3-red" style="width: 50%;">Cancel</button>
                    <button type="button" class="delete-btn w3-button w3-green w3-right" style="width: 50%;">Delete</button>
                </div>
            </div>
        </form>
    </div>


</body>

</html>