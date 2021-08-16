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
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Damion&display=swap">
<script src="https://kit.fontawesome.com/b7ab5ec9d0.js" crossorigin="anonymous"></script>
<script src="jquery.min.js"></script>
<script src="utilities\admin.js"></script>


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
    <div class="w3-center w3-black">Welcome, <?php echo $loggedName; ?></div>

    <div class="modal" style="display: block;">
        <a href="index.php" class="logo w3-display-topleft w3-padding-large w3-xlarge w3-border w3-margin w3-text-white">Roozter</a>
        <a href="schedule-edit.php" class="w3-display-topright w3-button w3-border w3-text-white w3-margin w3-hover-black w3-hover-border-deep-purple w3-hover-text-deep-purple w3-ripple" >Go to schedule</a>
        <a href="editProfile.php" class="w3-display-topmiddle w3-button w3-border w3-text-white w3-margin w3-hover-black w3-hover-border-blue w3-hover-text-deep-blue w3-ripple" style="top: 2%; left: 49%;">Edit profile info</a>

        <div class="w3-display-middle main-panel ">


            <div class="w3-container" style="margin-top:50px" id="showcase">
                <h1>Dashboard</h1>
            </div>

            <!--menu-->
            <div class="w3-bar w3-black w3-padding-small">

                <!-- Change view dropdown-->
                <select id="list-view-select" class="w3-input w3-bar-item w3-round">
                    <option disabled>View Schedule Information</option>
                    <option value="0" selected>Admin</option>
                    <option value="1">Teacher</option>
                    <option value="2">Classroom</option>
                    <option value="3">Subject</option>
                    <option value="4">Event</option>
                    <option value="5">Faculty</option>

                </select>

                <button disabled id="add-event-btn" class=" w3-bar-item w3-button w3-blue w3-round w3-right" style="margin-right: 5px;">Add</button>
                <input id="listSearch" type="search" class="w3-bar-item w3-search w3-round w3-right" placeholder="Search..." style="margin-right: 5px;"></input>
            </div>

            <!--list -->
            <div class="w3-white" style="overflow-y: scroll;max-height:365px;">

                <table class="w3-table w3-hoverable w3-striped">
                    <thead>
                        <tr class="w3-red">
                            <th id="view-name">Admin Name</th>
                            <th id="list-edit-col" class="w3-center">Activate/Deactivate</th>
                            <th class="w3-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="list">
                        <?php

                        $sql = 'SELECT * FROM `admin`';

                        $result = mysqli_query($conn, $sql);
                        $admin_list = array();

                        while ($row = $result->fetch_assoc()) {
                            $Admin_ID = $row['Admin_ID'];
                            array_push($admin_list, $Admin_ID);
                        }
                        foreach ($admin_list as $Admin_ID) {

                            $sql = 'SELECT User_Name,Verified FROM admin WHERE Admin_ID= "' . $Admin_ID . '";';
                            if ($result = mysqli_query($conn, $sql)) {
                                $row = mysqli_fetch_row($result);

                                //place admin info in corresponding cells.
                                echo '<tr><td>' . $row[0] . '</td>';

                                //activate button
                                echo '<td class="w3-center"><button data-id="' . $Admin_ID . '" class="activate-event-btn w3-button w3-green"';
                                echo ($Admin_ID == $_SESSION['loggedID']) ? "disabled" : "";
                                echo '>';
                                echo ($row[1] == 0) ? '<i class="fas fa-unlock"></i>' : '<i class="fas fa-user-lock"></i>';
                                echo '</button></td>';

                                //delete button
                                echo '<td class="w3-center"><button data-id="' . $Admin_ID . '" class="delete-event-btn w3-button w3-red" ';
                                echo ($Admin_ID == $_SESSION['loggedID']) ? "disabled" : "";
                                echo '><i class="fas fa-trash"></i></button></td></tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!--Add a teacher form-->
        <div id="add-teacher-form" class="modal">
            <form class="w3-display-middle w3-white w3-border w3-padding" method="POST">
                <div class="w3-container w3-padding w3-animate-opacity">
                    <span class="close-btn w3-button w3-display-topright w3-hover-red" title="Close Modal">&times;</span>

                    <input class="FirstName w3-input w3-border" placeholder="Firstname" type="text">
                    <input class="LastName w3-input w3-border" placeholder="Lastname" type="text">

                    <select id="Faculty-T" class="Faculty w3-input w3-border" name="Faculty" required>
                        <option selected disabled><br>Pick a faculty</option>
                        <?php
                        $sql = 'SELECT * FROM `faculty` WHERE NOT `Faculty_Name`="TEMP"';
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_row($result)) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                        ?>
                    </select>
                    <button class="submit-event-btn w3-button w3-green" style="width: 100%; margin-top: 10px;" type="submit">Add teacher</button></div>
                <div id="add-teacher-failed-msg" class="w3-center" style="width: 100%;"></div>
            </form>
        </div>


        <!--Add a subject form-->
        <div id="add-subject-form" class="modal">

            <form class="w3-display-middle w3-white w3-border w3-padding" method="POST">
                <div class="w3-container w3-padding w3-animate-opacity">
                    <span class="close-btn w3-button w3-display-topright w3-hover-red" title="Close Modal">&times;</span>

                    <div class="w3-container">
                        <label for="text"><b></br>Subject</b></label>
                        <input type="text" class="w3-input w3-border Subject" placeholder="Enter subject name" required>

                        <select class="Faculty w3-input w3-border" name="Faculty" required>

                            <option selected disabled><br>Pick a faculty</option>
                            <?php
                            $sql = 'SELECT * FROM `faculty`';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_row($result)) {
                                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                            }
                            ?>
                        </select>
                        <button class="submit-event-btn w3-button w3-green" style="width: 100%; margin-top: 10px;" type="submit">Add teacher</button></div>

                    <div id="add-subject-failed-msg" class="w3-center" style="width: 100%;"></div>
                </div>
            </form>
        </div>

        <!--Edit a subject form-->
        <div id="edit-subject-form" class="modal">

            <form class="w3-display-middle w3-white w3-border w3-padding">
                <div class="w3-container w3-padding w3-animate-opacity">
                    <span class="close-btn w3-button w3-display-topright w3-hover-red" title="Close Modal">&times;</span>

                    <div class="w3-container">
                        <label for="text"><b></br>Subject</b></label>
                        <input type="text" class="w3-input w3-border Subject" placeholder="Enter subject name" required>

                        <select class="Faculty w3-input w3-border" name="Faculty" required>

                            <option selected disabled><br>Pick a faculty</option>
                            <?php
                            $sql = 'SELECT * FROM `faculty`';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_row($result)) {
                                echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                            }
                            ?>
                        </select>
                        <input type="hidden" id="subjid">
                        <button class="submit-event-btn2 w3-button w3-green" style="width: 100%; margin-top: 10px;" type="submit">Edit subject</button></div>

                    <div id="edit-subject-failed-msg" class="w3-center" style="width: 100%;"></div>
                </div>
            </form>
        </div>

        <!--Edit teacher form-->
        <div id="edit-teacher-form" class="modal">
            <form class="w3-display-middle w3-white w3-border w3-padding">
                <div class="w3-container w3-padding">
                    <span class="close-btn w3-button w3-display-topright w3-hover-red" title="Close Modal">&times;</span>

                    <input class="w3-input w3-round w3-border" type="text" id="Fname" placeholder="Enter First name">
                    <input class="w3-input w3-round w3-border" type="text" id="Lname" placeholder="Enter Last name">
                    <select class="Faculty w3-input w3-round w3-border " name="Faculty" required>
                        <option disabled>Pick a faculty</option>
                        <?php
                        $sql = 'SELECT * FROM `faculty` WHERE NOT `Faculty_Name`="TEMP"';
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_row($result)) {
                            echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                        }
                        ?>
                    </select>
                    <input type="hidden" id="teachid">
                    <button class="submit-event-btn2 w3-button w3-green" style="width: 100%; margin-top: 10px;" type="submit">Save changes</button>
                    <div id="edit-teacher-failed-msg" class="w3-center" style="width: 100%;"></div>
                </div>
            </form>
        </div>

        <!--General add form-->
        <div id="add-form" class="modal">
            <form class="w3-display-middle w3-white w3-border w3-padding" method="POST">
                <div class="w3-container w3-padding w3-animate-opacity">
                    <span class="close-btn w3-button w3-display-topright w3-hover-red" title="Close Modal">&times;</span>

                    <input class="w3-input w3-round w3-border" type="text" id="Xname" style="margin-top: 30px;" placeholder="Enter name" required>
                    <input class="w3-input w3-round w3-border" type="number" min="1" id="XtraField" style="margin-top: 30px;" placeholder="Enter amount" disabled>
                    <input type="hidden" id="Xid">
                    <button class="submit-event-btn w3-button w3-green" style="width: 100%; margin-top: 10px;" type="submit">Add <span id="add-btn-span">name</span></button>
                    <div id="add-x-failed-msg" class="w3-center" style="width: 100%;"></div>

                </div>
            </form>
        </div>

        <!--general edit form-->
        <div id="edit-form" class="modal">
            <form class="w3-display-middle w3-white w3-border w3-padding">
                <span class="close-btn w3-button w3-display-topright w3-hover-red" title="Close Modal">&times;</span>

                <input class="w3-input w3-round w3-border" type="text" id="Xname2" style="margin-top: 30px;" placeholder="Enter new name" required>
                <input class="w3-input w3-round w3-border" type="number" min="1" id="XtraField2" style="margin-top: 30px;" placeholder="Enter amount" disabled>
                <input type="hidden" id="Xid2">
                <button class="submit-event-btn2 w3-button w3-green" style="width: 100%; margin-top: 10px;" type="submit">Save changes to <span id="edit-btn-span"></span></button>
                <div id="edit-x-failed-msg" class="w3-center" style="width: 100%;"></div>
            </form>
        </div>

        <!--confirmation box-->
        <div id="delete-confirmbox" class="modal">
            <form id="confirm-form" class="w3-white w3-display-middle w3-xlarge w3-card-4">
                <span onclick="document.getElementById('delete-confirmbox').style.display='none',document.getElementById('confirm-form').reset();" class="w3-button w3-display-topright" style="width: 52px;" title="Close Modal">&times;</span>
                <div class="w3-container w3-padding w3-center">
                    <h1>Delete Event</h1>
                    <p>Are you sure you want to delete <span></span>?</p>

                    <input id="delete-id" type="hidden">
                    <div id="confirmbox-btns">
                        <button type="button" class="cancel-btn w3-button w3-red" style="width: 50%;">Cancel</button>
                        <button type="button" class="delete-btn w3-button w3-green w3-right" style="width: 50%;">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>