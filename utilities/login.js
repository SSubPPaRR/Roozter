$(document).ready(function () {
    $("#login-open-btn").click(function () { 
        $("#login-form").fadeIn();
    });

    $(".login-close-btn").click(function () { 
        $("#login-form").hide();        
    });
    
});