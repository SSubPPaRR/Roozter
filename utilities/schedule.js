$(document).ready(function () {

    $("#today-btn").click(function (e) {
        e.preventDefault();
        $("#today-btn").css("background-color", "grey");
        $("#tommo-btn").css("background-color", "black");
        $.post("utilities\\loadSchedule.php", {
            totm: 1,
            user: 1
        },
            function (data) {
                $("#schedule").replaceWith(data);
            }
        );
    });

    $("#tommo-btn").click(function (e) {
        e.preventDefault();
        $("#tommo-btn").css("background-color", "grey");
        $("#today-btn").css("background-color", "black");
        $.post("utilities\\loadSchedule.php", {
            totm: 2,
            user: 1
        },
            function (data) {
                $("#schedule").replaceWith(data);
            }
        );
    });

    $("#sort-menu-btn").click(function (e) {
        e.preventDefault();
        $("#sort-menu").show();
        $('#failed-sort-msg').empty();
        document.getElementById('sort-form').reset();

    });

    $("#scheduleSearch").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#schedule tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $('#print-btn').click(function (e) { 
        e.preventDefault();
        $('#schedule-table').printThis();
    });


    //close
    $('.close-btn').click(function (e) {
        e.preventDefault();
        $(this).closest('.modal').hide();
    });

    //load new options on faculty change
    $(".Faculty").change(function (e) {
        e.preventDefault();
        var facid = $(this).val();
        console.log("faculty id: " + facid);

        $.post("utilities\\addEvent.php", {
            option: 0,
            FacID: facid
        }, function (data) {
            //$("#option-teacher").replaceWith(data);
            $('.Faculty').siblings('.Teacher').children('.option-teacher').replaceWith(data);
        });

        $.post("utilities\\addEvent.php", {
            option: 1,
            FacID: facid
        }, function (data) {
            //$("#option-subject").replaceWith(data);
            $('.Faculty').siblings('.Subject').children('.option-subject').replaceWith(data);

        });
    });
    var isDateSet = false;

    //force to set 'To' date when setting 'From' date and vice-versa
    $('#from').change(function (e) {
        e.preventDefault();
        if (!(($('#from').val() == "" || $('#from').val() == null) == ($('#to').val() == "" || $('#to').val() == null))) {
            console.log('required set');
            if($('#from').val() == "" || $('#from').val() == null){
             $('#failed-sort-msg').html('<div class="w3-text-red w3-center">Missing "From" date.</div>'); 
            } 
            else $('#failed-sort-msg').html('<div class="w3-text-red w3-center">Missing "To" date.</div>');

            isDateSet = true;
        }
        else {
            console.log('required removed');
            $('#failed-sort-msg').empty();
            isDateSet = false;
        }
    });

    $('#to').change(function (e) {
        e.preventDefault();
        if (!(($('#from').val() == "" || $('#from').val() == null) == ($('#to').val() == "" || $('#to').val() == null))) {
            console.log('required set');
            if($('#to').val() == "" || $('#to').val() == null){
                $('#failed-sort-msg').html('<div class="w3-text-red w3-center">Missing "To" date.</div>'); 
            } 
            else $('#failed-sort-msg').html('<div class="w3-text-red w3-center">Missing "From" date.</div>');
   
            isDateSet = true;
        }
        else {
            console.log('required removed');
            $('#failed-sort-msg').empty();
            isDateSet = false;
        }
    });

        //sorting table with sort menu
    $('#sort-btn').click(function (e) {
        e.preventDefault();

        //check if set dates are correct
        if (!isDateSet && ($('#from').val()<=$('#to').val())) {
            var sql = "SELECT ScheduleID FROM schedule WHERE ";
            var sqlBase = sql + ' ORDER BY `Date` DESC,`Start` DESC;';
            var i = 0;

            //generate query based on chosen search option 
            $(".Sortinput").each(function (index, element) {
                // element == this

                if ($(element).val() != "" && $(element).val() != null) {

                    if ($(element).hasClass("Faculty")) {
                        if (i > 0) {
                            sql = sql + " AND ";
                        }
                        i++;
                        sql = sql + "FacultyID = " + $(element).val() + "";

                    }
                    else if ($(element).hasClass("Teacher")) {
                        if (i > 0) {
                            sql = sql + " AND ";
                        }
                        i++;
                        sql += "TeacherID = " + $(element).val() + "";

                    }
                    else if ($(element).hasClass("Subject")) {
                        if (i > 0) {
                            sql = sql + " AND ";
                        }
                        i++;
                        sql += "SubjectID = " + $(element).val() + "";

                    }
                    else if ($(element).hasClass("From")) {
                        if (i > 0) {
                            sql = sql + " AND ";
                        }

                        i++;
                        sql += "Date BETWEEN '" + $(element).val() + "'";

                    }
                    else if ($(element).hasClass("To")) {
                        if (i > 0) {
                            sql = sql + " AND ";
                        }
                        i++;
                        sql = sql + "'" + $(element).val() + "'";

                    }
                    else if ($(element).hasClass("Event")) {
                        if (i > 0) {
                            sql = sql + " AND ";
                        }
                        i++;
                        sql += "EventID = " + $(element).val() + "";

                    }
                    else if ($(element).hasClass("Status")) {
                        if (i > 0) {
                            sql = sql + " AND ";
                        }
                        i++;
                        sql += "Status = " + $(element).val() + "";


                    }
                }
            });
            sql = sql + ' ORDER BY `Date` DESC,`Start` DESC;';

            // check if sort input is blank
            if (sql != sqlBase) {
                console.log(sql);

                $.post("utilities\\loadSchedule.php", {
                    sql: sql,
                    user: 1
                },
                    function (data) {
                        $("#schedule").replaceWith(data);
                        $('#sort-menu').hide();
                    }
                );
            }
            else {
                console.log('No sort input');
                $('#failed-sort-msg').html('<div class="w3-text-red w3-center">All input fields are empty.</div>');
            }
        }else{
            console.log('"from" date larger than "to" date.');
            $('#failed-sort-msg').html('<div class="w3-text-red w3-center">"from" date is larger than "to" date.</div>');
        }
    });


    function refreshSchedule() {

        //refresh schedule
        if ($("#today-btn").css("background-color") == "rgb(128, 128, 128)") {

            $.post("utilities\\loadSchedule.php", {
                totm: 1,
                user: 1
            },
                function (data) {
                    $("#schedule").replaceWith(data);
                }
            );
        } else {
            $.post("utilities\\loadSchedule.php", {
                totm: 2,
                user: 1
            },
                function (data) {
                    $("#schedule").replaceWith(data);
                }
            );
        }
    }
});