<?php

session_start();
unset($_SESSION['loggedID']);
unset($_SESSION['loggedName']);


ob_start(); // ensures anything dumped out will be caught
                $url = "..\index.php"; // this can be set based on whatever
                // clear out the output buffer
                while (ob_get_status()) 
                {
                    ob_end_clean();
                }
                // redirect
                header( "Location: $url" );
?>