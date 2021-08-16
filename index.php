<?php
session_start();
include 'utilities\\sesCheck.php';

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
<script src="jquery.min.js"></script>

<script src="utilities\login.js"></script>
<script src="utilities\loginVal.js"></script>


<style>
body,h1 {font-family: "Raleway", sans-serif}
body, html {height: 100%}
.bgimg {
  background-image: url('images/forestbridge.jpg');
  min-height: 100%;
  background-position: center;
  background-size: cover;
}

.logo{
  font-family: 'Damion', cursive;
  text-decoration: none;
  
}
</style>
<body>
    <div class="w3-center w3-black"><?php echo ($loggedID =="") ? "Welcome": "Welcome, ".$loggedName; ?></div>

    <div class="bgimg w3-display-container w3-animate-opacity w3-text-white">

        <a href="index.php" class="logo w3-display-topleft w3-padding-large w3-xlarge w3-border w3-margin w3-text-white">Roozter</a>
        <?php if($loggedID =! "" && isset($_SESSION['loggedID'])){ echo '<a href="admin.php" class="w3-display-topright w3-padding-large w3-xlarge w3-button w3-border w3-margin w3-hover-black w3-hover-border-deep-purple w3-hover-text-deep-purple w3-ripple">Admin options</a>';}?>

        <div class="w3-display-middle w3-center">
            <a href= <?php echo ($loggedID =! "" && isset($_SESSION['loggedID']))? '"schedule-edit.php"' : '"schedule.php"' ?> class="w3-button w3-jumbo w3-animate-top w3-border w3-hover-black w3-hover-border-indigo w3-hover-text-indigo w3-ripple" style="margin-bottom: 5px;">Open schedule</a>
            <hr class="w3-border-grey" style="margin:auto;width:40%">
            <?php
                if($loggedID == "" || !(isset($_SESSION['loggedID']))){
                    echo '<a id="login-open-btn" class=" w3-button w3-large w3-center w3-border w3-hover-black w3-animate-bottom w3-hover-border-green w3-hover-text-green w3-ripple" style="margin-top: 5px;">Login</a>';

                }else echo '<a href="utilities\\logout.php" class=" w3-button w3-large w3-center w3-border w3-animate-bottom w3-hover-black w3-hover-border-red w3-hover-text-red w3-ripple" style="margin-top: 5px;">Logout</a>';
            ?>
        </div>

        <div class="w3-display-bottomleft w3-padding-large">
            Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a>
        </div>
    </div>

    <!--login form-->
    <div id="login-form" class="modal">

        <form id="form" class="w3-display-middle w3-white w3-border w3-black" action="utilities\loginVal.php" method="POST">
            <div class="w3-center w3-margin-top">
            <span class="w3-button w3-display-topright w3-hover-red login-close-btn" title="Close Modal">&times;</span>
            <img class="w3-circle" style="width: 50%;" src="images\img_avatar.png" alt="Avatar">
            </div>

            <div class="w3-container">
            <label id="failed-login-msg"></label>
            <label for="username"><b>Username</b></label>
            <input id="username"  title="" class="w3-input w3-border" placeholder="Enter Email" required>

            <label for="psw"><b>Password</b></label>
            <input id="psw"  class="w3-input w3-border" style="width: 100%;" type="password" placeholder="Enter Password" required>
                
            <button id="login-btn" class="w3-button w3-green w3-margin-top" style="width: 100%;" type="submit">Login</button>
            </div>

            <div class="w3-padding w3-black" style="background-color:#f1f1f1;width:100%;">
            <span >Register, <a class="w3-text-blue" href="register.php">here</a></span>
            </div>
        </form>
    </div>
</body>
</html>
