    var usernameResponse;
    var passwordResponse;
    $(document).ready(function () {
    $('#update-Form input').change(function (e) {
        e.preventDefault();
        $('#profile-update-msg').empty();
        $('#profile-update-msg2').empty();
        //$('#profile-update-msg').removeProp('disabled');
    });

    $("#update-Form").submit(function (e) {
        e.preventDefault();
        //$("#updateButton").prop("disabled",true);

        

        var username = $('#Username').val();
        if (username != "" && username != null) {
            $.post("utilities\\updateQuery.php", { username: username, option: 2 },
                function (data) {

                    console.log(data)
                    usernameResponse = data;
                    $('#profile-update-msg').html(data);

                }
            );
        }

        var newPass = $("#psw").val();

        if (newPass != "" && newPass != null) {
            var oldPass = $("#oldPass").val();

            $.post("utilities\\updateQuery.php", { oldPass: oldPass, option: 0 },
                function (data) {
                    if (data == 1) {
                        console.log("Correct old password");
                        passwordResponse = "Correct old password";
                        $.post("utilities\\updateQuery.php", { newPass: newPass, option: 1 },
                            function (data) {

                                console.log(data)
                                passwordResponse = data;
                                $('#profile-update-msg2').html(data);


                            }

                        );
                    } else {
                        console.log("Incorrect old password");
                       
                        $('#profile-update-msg2').html('<span class="w3-text-red">Incorrect old password</span>');

                    }


                }

            );
        }

        
    });

});
