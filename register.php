<?php
session_start();

?>
<!DOCTYPE html>
<html>
<title>Roozter</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<script src="jquery.min.js"></script>
<script src="utilities\register.js"></script>

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
</style>

<body class="bgimg">
  <div class="modal" style="display: block;">
    <!--register form-->
    <form id="form" class="w3-display-middle w3-black w3-border w3-card-4">
      <div class="w3-center w3-margin-top">
        <img class="w3-circle" style="width: 40%;" src="images\img_avatar.png" alt="Avatar" class="avatar">
      </div>

      <div id="Status-msg"></div>

      <div class="w3-container input-fields">

        <label for="Username"><b>Username</b></label>
        <input id="Username" name="Username" class="w3-input w3-border" placeholder="Enter Username" required>

        <label for="psw"><b>Password</b></label>
        <input id="psw" name="Password" class="w3-input w3-border" style="width: 100%;" type="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="Minimum eight characters, at least one uppercase letter, one lowercase letter and one number." placeholder="Enter Password" required>

        <label for="cpsw"><b>Confirm password</b></label>
        <input id="cpsw" name="Password" class="w3-input w3-border" style="width: 100%;" type="password" placeholder="Enter Password" required>

        <button id="register-btn" class="w3-button w3-green w3-margin-top" style="width: 100%;" type="submit">Register</button>
      </div>
      <div class='w3-container'><a class=" w3-button w3-grey w3-margin-top w3-margin-bottom " href="index.php" style="width: 100%;">Back to site</a></div>
    </form>
  </div>
</body>

</html>