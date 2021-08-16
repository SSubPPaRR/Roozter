<?php

    if(isset($_SESSION['loggedID'])){
       $loggedID = $_SESSION['loggedID'];
    }else $loggedID = "";

    if(isset($_SESSION['loggedName'])){
        $loggedName = $_SESSION['loggedName'];
    }else $loggedName = "";

?>