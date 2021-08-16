//used in schedule-edit.php
$(document).ready(function () {

    $("#today-btn").click(function (e) {
        e.preventDefault();
        $("#today-btn").css("background-color", "grey");
        $("#tommo-btn").css("background-color", "black");
        $.post("utilities\\loadSchedule.php", {
            totm: 1,
            user: 0
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
            user: 0
        },
            function (data) {
                $("#schedule").replaceWith(data);
            }
        );
    });

    $("#scheduleSearch").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#schedule tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    //end date
    var multiWeek = 0;
    $('#End-check').click(function () {

        if ($(this).prop("checked") == true) {
            multiWeek = 1;
            console.log("Checkbox is checked.\nmultiWeek set to:" + multiWeek);
            $('#endDate').prop('disabled', false);
            $('#endDate').prop('required', true);
        }
        if ($(this).prop("checked") == false) {
            multiWeek = 0;
            console.log("Checkbox is unchecked.\nmultiWeek set to:" + multiWeek);
            $('#endDate').prop('required', false);
            $('#endDate').prop('disabled', true);
        }

    });

    //classroom capacity filter
    $('.capacity-check').click(function () {

        if ($(this).prop("checked") == true) {
            console.log("Checkbox is checked.\n");
            $('.capacity-filter').prop('disabled', false);
            $('.capacity-filter').prop('required', true);
        }
        if ($(this).prop("checked") == false) {
            console.log("Checkbox is unchecked.\n");
            $('.capacity-filter').prop('required', false);
            $('.capacity-filter').prop('disabled', true);
            $('.capacity-filter').val("");
            $('.option-classroom option').show();
            $("#add-form .Classroom").val("");
        }
    });

    $('.capacity-filter').change(function () {
        if ($('.capacity-filter').attr("id") == "capFilter1") {
            classroomFilter(1);
        }
        else {
            classroomFilter(2);
        }
    });

    function classroomFilter(x) {
        var capFilter;
        if (x == 1) {
            capFilter = parseInt($('#capFilter1').val());
        }
        else {
            capFilter = parseInt($('#capFilter2').val());
        }

        $('.option-classroom option').each(function (index, element) {
            var captest = parseInt($(element).attr("data-cap"));
            if (captest >= capFilter) {
                $(element).show();
            } else {
                $(element).hide();
            }
        });
    }

    //Verify capacity value
    $('.capacity-filter').change(function () {
        if ($(this).val() < $(this).attr("min")) {
            $(this).val($(this).attr("min"));
        }
    });

    //open window
    $("#add-event-btn").click(function (e) {
        e.preventDefault();
        $("#add-event-form").show();
        $("#submit-event-btn").removeAttr("disabled");
    });

    //edit event
    $("body").on("click", ".edit-event-btn", function () {

        $("#submit-event-btn2").removeAttr("disabled");

        $("#edit-event-form").show();
        var schedID = $(this).attr("data-id");
        var date = $(this).parent().siblings('.col-date').html();
        var start = $(this).parent().siblings('.col-start').html();
        var end = $(this).parent().siblings('.col-end').html();
        var fac = $(this).parent().siblings('.col-fac').html();
        var event = $(this).parent().siblings('.col-event').html();
        var teacher = $(this).attr("data-teacher");
        var subject = $(this).parent().siblings('.col-subj').html();
        var classroom = $(this).parent().siblings('.col-class').html();
        var status = $(this).parent().siblings('.col-stat').children('span').html();
        console.log(teacher)
        $("#edit-event-form .Date").val(date);
        $("#edit-event-form .Start").val(start);
        $("#edit-event-form .End").val(end);
        $("#scheduleID").val(schedID);

        //getting faculty value
        $("#edit-event-form .Faculty option").each(function () {
            if ($(this).text() == fac) {
                var facid = $(this).val();
                //set faculty
                $("#edit-event-form .Faculty").val(facid);
                console.log("faculty id: " + facid);

                //teacher
                $.post("utilities\\editEvent.php", {
                    option: 0,
                    FacID: facid
                }, function (data) {
                    $(".option-teacher").replaceWith(data);

                    //set to chosen teacher
                    $("#edit-event-form .Teacher option").each(function () {
                        if ($(this).text() == teacher) {
                            $("#edit-event-form .Teacher").val($(this).val());
                        }
                    });
                }
                );
                //subject
                $.post("utilities\\editEvent.php", {
                    option: 1,
                    FacID: facid
                }, function (data) {
                    $(".option-subject").replaceWith(data);

                    //set to chosen subject
                    $("#edit-event-form .Subject option").each(function () {
                        if ($(this).text() == subject) {
                            $("#edit-event-form .Subject").val($(this).val());
                        }
                    });

                }
                );

            }
        })


        //set to chosen classroom
        $("#edit-event-form .Classroom option").each(function () {
            if ($(this).text() == classroom) {
                $("#edit-event-form .Classroom").val($(this).val());
            }
        });

        //set to chosen event
        $("#edit-event-form .Event option").each(function () {
            if ($(this).text() == event) {
                $("#edit-event-form .Event").val($(this).val());
            }
        });



        //set to chosen status
        $("#edit-event-form .Status option").each(function () {
            if ($(this).text() == status) {
                $("#edit-event-form .Status").val($(this).val());
            }
        });

    });

    //close window
    $("#add-event-close-btn").click(function (e) {
        e.preventDefault();
        $("#add-event-form").hide();
        document.getElementById('add-form').reset();
        $("#failed-add-msg").empty();    //replaceWith('<div id="failed-add-msg"></div>');

    });

    $("#edit-event-close-btn").click(function (e) {
        e.preventDefault();
        $("#edit-event-form").hide();
        document.getElementById('edit-form').reset();
        $("#failed-edit-msg").empty();    //replaceWith('<div id="failed-edit-msg"></div>');        

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
        }
        );

        $.post("utilities\\addEvent.php", {
            option: 1,
            FacID: facid
        }, function (data) {
            //$("#option-subject").replaceWith(data);
            $('.Faculty').siblings('.Subject').children('.option-subject').replaceWith(data);

        }
        );
    });

    //load classroom options on date/time change
    $('.Date,.Start,.End').change(function (e) {
        e.preventDefault();
        console.log("change classroom options.");

        if ($($(this).parents('.modal')).attr('id') == "add-event-form") {
            console.log("this is a add form");

            var option2 = 0;
            var date = $('#add-event-form .Date').val();
            var start = $('#add-event-form .Start').val();
            var end = $('#add-event-form .End').val();
        }
        else if ($($(this).parents('.modal')).attr('id') == "edit-event-form") {
            console.log("this is a edit form");

            var option2 = 1;
            var date = $('#edit-event-form .Date').val();
            var start = $('#edit-event-form .Start').val();
            var end = $('#edit-event-form .End').val();
            var schedid = $("#scheduleID").val();
        }
        console.log("date: " + date + " Start: " + start + " End: " + end)

        if ((date != "") && (start != "") && (end != "")) {
            console.log("valid for classroom list request.\nGetting list.");

            $.post("utilities\\addEvent.php", {
                option: 3,
                option2: option2,
                scheduleID: schedid,
                Date: date,
                Start: start,
                End: end
            }, function (data) {
                if (option2 == 0) {
                    $('#add-event-form .Classroom').children('.option-classroom').replaceWith(data);
                } else $('#edit-event-form .Classroom').children('.option-classroom').replaceWith(data);
            }
            );

        }
        else console.log("invalid for classroom list request.");
    });


    //re-enable edit-form submit button in field change
    $("#edit-form").change(function (e) {
        e.preventDefault();
        if ($("#submit-event-btn2").attr('disabled')) {
            $("#submit-event-btn2").removeAttr("disabled");
        }
    });

    //submit add form
    $("#add-form").submit(function (e) {
        $("#submit-event-btn").attr("disabled", "true");

        e.preventDefault();
        $("#failed-add-msg").replaceWith('<div id="failed-add-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\\Infinity-1s-200px.svg"></div>');

        var facid = $("#add-form .Faculty").val();
        var date = $("#add-form .Date").val();
        var start = $("#add-form .Start").val();
        var end = $("#add-form .End").val();
        var teacher = $("#add-form .Teacher").val();
        var event = $("#add-form .Event").val();
        var subject = $("#add-form .Subject").val();
        var classroom = $("#add-form .Classroom").val();
        var status = $("#add-form .Status").val();
        var endDate = $('#endDate').val();

        $.post("utilities\\addEvent.php", {
            option: 2,
            FacID: facid,
            Start: start,
            End: end,
            TeachID: teacher,
            ClassID: classroom,
            EvID: event,
            SubID: subject,
            StatID: status,
            DatID: date,
            endDate: endDate,
            multiWeek: multiWeek

        }, function (data) {
            $("#failed-add-msg").replaceWith(data);
            refreshSchedule();
        }
        );
    });


    //submit edit form
    $("#edit-form").submit(function (e) {
        $("#submit-event-btn2").attr("disabled", "true");

        e.preventDefault();
        $("#failed-edit-msg").replaceWith('<div id="failed-edit-msg" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\\Infinity-1s-200px.svg"></div>');

        var schedID = $("#scheduleID").val();
        var facid = $("#edit-form .Faculty").val();
        var date = $("#edit-form .Date").val();
        var start = $("#edit-form .Start").val();
        var end = $("#edit-form .End").val();
        var teacher = $("#edit-form .Teacher").val();
        var event = $("#edit-form .Event").val();
        var subject = $("#edit-form .Subject").val();
        var classroom = $("#edit-form .Classroom").val();
        var status = $("#edit-form .Status").val();

        $.post("utilities\\editEvent.php", {
            option: 2,
            FacID: facid,
            Start: start,
            End: end,
            TeachID: teacher,
            ClassID: classroom,
            EvID: event,
            SubID: subject,
            StatID: status,
            DatID: date,
            SchedID: schedID

        }, function (data) {
            $("#failed-edit-msg").replaceWith(data);
            //refresh table to show new results

            refreshSchedule();
        }
        );
    });


    //delete event
    $("body").on("click", ".delete-event-btn", function () {
        $("#delete-confirmbox").show();
        $("#delete-id").val($(this).attr("data-id"));
        $.get("schedule-edit.php",
            function (data) {
                $("#confirmbox-btns").replaceWith($(data).find("#confirmbox-btns"));
            }
        );
    });

    //cancel
    $("body").on("click", "#delete-confirmbox .cancel-btn", function () {
        document.getElementById('confirm-form').reset();
        $("#delete-confirmbox").hide();
    });

    //delete
    $("body").on("click", "#delete-confirmbox .delete-btn", function () {
        var SchedID = $("#delete-id").val();
        $("#confirmbox-btns").replaceWith('<div id="confirmbox-btns" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\\Infinity-1s-200px.svg"></div>');
        $.post("utilities\\deleteEvent.php", {
            option: 0,
            SchedID: SchedID
        },
            function (data) {
                $("#confirmbox-btns").replaceWith(data);
                refreshSchedule();
            }
        );
    });

    function refreshSchedule() {

        //refresh schedule
        if ($("#today-btn").css("background-color") == "rgb(128, 128, 128)") {

            $.post("utilities\\loadSchedule.php", {
                totm: 1,
                user: 0
            },
                function (data) {
                    $("#schedule").replaceWith(data);
                }
            );
        } else {
            $.post("utilities\\loadSchedule.php", {
                totm: 2,
                user: 0
            },
                function (data) {
                    $("#schedule").replaceWith(data);
                }
            );
        }
    }

});
