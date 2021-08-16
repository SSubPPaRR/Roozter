$(document).ready(function () {

    $("#form").submit(function (e) { 
        e.preventDefault();
        var username = $("#Username").val();
        var password = $("#psw").val();

        $("#Status-msg").replaceWith("<div id='Status-msg' class='w3-center'><img src='images\\Loading1.gif' style='max-height: 90px;'></div>")
        $("#register-btn").attr("disabled", true);
        $.post("utilities/registration.php",{
            username : username,
            password: password
        },function(data,textStatus){
            $("#Status-msg").replaceWith(data);

            $(document).ready(function () {
                var type = $("#Status-msg").attr("data-type");
                if(type=="0"){
                    $("#register-btn").attr("disabled", false);
                }
            });
        });
    });
});