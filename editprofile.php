<?php
session_start();



?>
<!DOCTYPE html>
<html>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<script src="jquery.min.js"></script>
<script src="utilities\updateProfile.js"></script>

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
    <form id="update-Form" class="w3-display-middle w3-black w3-border w3-card-4">
      <div class="w3-center w3-margin-top">
        <img class="w3-circle" style="width: 40%;" src="images\img_avatar.png" alt="Avatar" class="avatar">
      </div>

      <div class="w3-container input-fields">
        <div>
          <label for="Username"><b>Username</b></label>
          <input id="Username" name="Username" class="w3-input w3-border" placeholder="Enter Username">

          <label for="oldPass"><b>old Password</b></label>
          <input id="oldPass" name="oldPass" class="w3-input w3-border" style="width: 100%;" type="password" placeholder="Enter Password">

          <label for="psw"><b>Password</b></label>
          <input id="psw" name="Password" class="w3-input w3-border" style="width: 100%;" type="password" placeholder="Enter Password">


          <label for="cpsw"><b>Confirm password</b></label>
          <input id="cpsw" name="newPass" class="w3-input w3-border" style="width: 100%;" type="password" placeholder="Enter Password">
        </div>
        <div id="profile-update-msg" class="w3-center"></div>
        <div id="profile-update-msg2" class="w3-center"></div>
        <button id="updateButton" class="w3-button w3-green w3-margin-top" style="width: 100%;" type="submit">update </button><br></br>
        <a href="admin.php" class="w3-button w3-grey" style="width: 100%;" type="submit">Return to admin</a><br></br>

      </div>
    </form>

  </div>
  </form>
  </div>
</body>
<script>
  function validatePassword() {
    if (psw.value != cpsw.value) {
      cpsw.setCustomValidity("Passwords Don't Match");
    } else {
      cpsw.setCustomValidity('');
    }
  }

  psw.onchange = validatePassword;
  cpsw.onkeyup = validatePassword;
</script>

</html>