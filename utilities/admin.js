$(document).ready(function () {

    //search
    $("#listSearch").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#list tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    //view selection
    $('#list-view-select').change(function (e) {
        e.preventDefault();

        if ($('#list-view-select').val() == 0) {
            $('#list-edit-col').html("Activate/Deactivate");
        } else $('#list-edit-col').html("Edit");

        refreshList();
    });

    //activate event
    $("body").on("click", ".activate-event-btn", function () {
        var id = $(this).attr("data-id");
        $.post("utilities\\activateEvent.php", { AdminID: id },
            function (data) {
                refreshList();
            }
        );
    });

    //add event
    $('#add-event-btn').click(function (e) {
        e.preventDefault();

        var viewOption = $('#list-view-select').val();

        if (parseInt(viewOption) == 1) {
            $('#add-teacher-form').show();
            $('#add-teacher-failed-msg').replaceWith('<div id="add-teacher-failed-msg" class=" w3-center" style="width: 100%;"></div>');
            $.get("admin.php", function (data) {

                $('#Faculty-T').replaceWith($(data).find('#Faculty-T'));
            });

        } else if (parseInt(viewOption) == 3) {
            $('#add-subject-form').show();
            $('#add-subject-failed-msg').replaceWith('<div id="add-subject-failed-msg" class=" w3-center" style="width: 100%;"></div>');

        } else {

            $('#Xname').val("");
            $('#XtraField').val("");

            //enable/disable capacity field for classroom.
            if (parseInt(viewOption) == 2) {
                $('#XtraField').prop('disabled', false);
                $('#XtraField').prop('required', true);
                $('#add-btn-span').text("classroom");
            }
            else {
                $('#XtraField').prop('required', false);
                $('#XtraField').prop('disabled', true);

                if (parseInt(viewOption) == 4) {
                    $('#add-btn-span').text("event");
                }
                if (parseInt(viewOption) == 5) {
                    $('#add-btn-span').text("faculty");
                }
            }
            $('#add-form').show();
            $('#add-x-failed-msg').replaceWith('<div id="add-x-failed-msg" class="w3-center" style="width: 100%;"></div>');
        }

    });

    //edit event(open menu)
    $("body").on("click", ".edit-event-btn", function () {
        var viewOption = $('#list-view-select').val();

        //teacher
        if (parseInt(viewOption) == 1) {
            $('#edit-teacher-form').show();
            $("#Fname").val($(this).attr("data-fname"));
            $("#Lname").val($(this).attr("data-lname"));
            $("#teachid").val($(this).attr("data-id"));

            var fac = $(this).attr("data-fid");
            $("#edit-teacher-form").find(".Faculty").val(fac);
            $('#edit-teacher-failed-msg').replaceWith('<div id="edit-teacher-failed-msg" class=" w3-center" style="width: 100%;"></div>');

        }

        //subject
        else if (parseInt(viewOption) == 3) {
            $('#edit-subject-form').show();
            $($('#edit-subject-form .Subject').val($(this).parent().siblings('.xname').html()));
            //$($('#edit-subject-form').children('.Faculty')).val();
            $("#subjid").val($(this).attr("data-id"));
            var fac = $(this).attr("data-fid");
            $("#edit-subject-form").find(".Faculty").val(fac);
            $('#edit-subject-failed-msg').replaceWith('<div id="edit-subject-failed-msg" class=" w3-center" style="width: 100%;"></div>');

        }

        //general
        else {
            if (parseInt(viewOption) == 2) {
                $('#XtraField2').prop('disabled', false);
                $('#XtraField2').prop('required', true);
                var cap = parseInt($(this).attr("data-cap"));
                $('#XtraField2').val(cap);
                $('#edit-btn-span').text("classroom");

            }
            else {
                $('#XtraField2').prop('required', false);
                $('#XtraField2').prop('disabled', true);
                $('#XtraField2').val("");

                if (parseInt(viewOption) == 4) {
                    $('#edit-btn-span').text("event");
                }
                if (parseInt(viewOption) == 5) {
                    $('#edit-btn-span').text("faculty");
                }

            }
            $('#edit-form').show();
            $("#Xname2").val($(this).parent().siblings('.xname').html());
            $("#Xid2").val($(this).attr("data-id"));
            $('#edit-x-failed-msg').replaceWith('<div id="edit-x-failed-msg" class="w3-center" style="width: 100%;"></div>');

        }
    });

    //Verify capacity value
    $('#XtraField,#XtraField2').change(function () { 
       if($(this).val() < $(this).attr("min")) {
        $(this).val($(this).attr("min"));
       }       
    });

    //delete event
    $("body").on("click", ".delete-event-btn", function () {
        $("#delete-confirmbox").show();
        $("#delete-id").val($(this).attr("data-id"));
        $.get("admin.php",
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
        var DelID = $("#delete-id").val();
        var viewOption = $('#list-view-select').val();

        $("#confirmbox-btns").replaceWith('<div id="confirmbox-btns" class="w3-center" style="width: 100%;"><img style="width: 50px;" src="images\\Infinity-1s-200px.svg"></div>');
        $.post("utilities\\deleteList.php", {
            option: viewOption,
            DelID: DelID
        },
            function (data) {
                $("#confirmbox-btns").replaceWith(data);

                refreshList();
            }
        );
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

    //close
    $('.close-btn').click(function (e) {
        e.preventDefault();
        $(this).closest('.modal').hide();
    });

    //add submit
    $('.submit-event-btn').click(function (e) {
        e.preventDefault();
        var formId = $(this).closest('.modal').attr('id');

        //general add form
        if (formId == "add-form") {
            $('#add-x-failed-msg').replaceWith('<div id="add-x-failed-msg" class=" w3-center" style="width: 100%;">loading</div>');
            console.log('add-form');

            var viewOption = parseInt($('#list-view-select').val());
            var xName = $('#Xname').val();
            var xField = $('#XtraField').val();

            $.post("utilities\\listAdd.php", { option: viewOption, name: xName, cap: xField },
                function (data) {
                    $('#add-x-failed-msg').replaceWith(data);
                    refreshList();
                }
            );
        }
        else if (formId == "add-subject-form") {
            $('#add-subject-failed-msg').replaceWith('<div id="add-subject-failed-msg" class=" w3-center" style="width: 100%;">loading</div>');
            console.log('add-subject-form');
            var xName = $($(this).siblings('.Subject')).val();
            var faculty = $($(this).siblings('.Faculty')).val();

            $.post("utilities\\listAdd.php", { option: 3, name: xName, fac: faculty },
                function (data) {
                    $('#add-subject-failed-msg').replaceWith(data);
                    refreshList();
                }
            );
        }
        else if (formId == "add-teacher-form") {
            $('#add-teacher-failed-msg').replaceWith('<div id="add-teacher-failed-msg" class=" w3-center" style="width: 100%;">loading</div>');
            console.log('#add-teacher-form');
            var lName = $($(this).siblings('.LastName')).val();
            var fName = $($(this).siblings('.FirstName')).val();
            var faculty = $($(this).siblings('.Faculty')).val();

            $.post("utilities\\listAdd.php", {
                option: 1,
                lName: lName,
                fName: fName,
                fac: faculty
            },
                function (data) {
                    $('#add-teacher-failed-msg').replaceWith(data);
                    refreshList();
                }
            );
        }
    });

    //edit submit
    $('.submit-event-btn2').click(function (e) {
        e.preventDefault();
        var formId = $(this).closest('.modal').attr('id');

        //general edit form
        if (formId == "edit-form") {
            $('#edit-x-failed-msg').replaceWith('<div id="edit-x-failed-msg" class=" w3-center" style="width: 100%;">loading</div>');
            console.log('edit-form');

            var viewOption = parseInt($('#list-view-select').val());
            var xName = $('#Xname2').val();
            var xField2 = $('#XtraField2').val();
            var id = $('#Xid2').val();

            $.post("utilities\\editEvent.php", { option: (viewOption + 2), ID: id, xName: xName, cap: xField2 },
                function (data) {
                    $('#edit-x-failed-msg').replaceWith(data);
                    refreshList();
                }
            );
        }

        //subject edit form
        else if (formId == "edit-subject-form") {
            $('#edit-subject-failed-msg').replaceWith('<div id="edit-subject-failed-msg" class=" w3-center" style="width: 100%;">loading</div>');
            console.log('edit-subject-form');
            var xName = $('#edit-subject-form .Subject').val();
            console.log(xName);
            var faculty = $('#edit-subject-form').find('.Faculty').val();
            var id = $('#subjid').val();

            $.post("utilities\\editEvent.php", { option: 5, subjName: xName, ID: id, fac: faculty },
                function (data) {
                    $('#edit-subject-failed-msg').replaceWith(data);
                    refreshList();
                }
            );
        }

        //teacher edit form
        else if (formId == "edit-teacher-form") {
            $('#edit-teacher-failed-msg').replaceWith('<div id="edit-teacher-failed-msg" class=" w3-center" style="width: 100%;">loading</div>');
            console.log('edit-teacher-form');
            var lName = $('#Lname').val();
            var fName = $('#Fname').val();
            var faculty = $('#edit-teacher-form').find('.Faculty').val();
            var id = $('#teachid').val();
            $.post("utilities\\editEvent.php", {
                option: 3,
                ID: id,
                lName: lName,
                fName: fName,
                fac: faculty
            },
                function (data) {
                    $('#edit-teacher-failed-msg').replaceWith(data);
                    refreshList();
                }
            );
        }
    })

    function refreshList() {
        var viewOption = $('#list-view-select').val();
        console.log('Listview:' + viewOption);
        $("#edit-event-btn").removeAttr("disabled");
        $("#add-event-btn").removeAttr("disabled");
        switch (parseInt(viewOption)) {
            case 0: $('#view-name').html("Admin Name");
                $("#edit-event-btn").attr("disabled", "true");
                $("#add-event-btn").attr("disabled", "true");
                break;
            case 1: $('#view-name').html("Teacher Name");
                break;
            case 2: $('#view-name').html("Classroom");
                break;
            case 3: $('#view-name').html("Subject");
                break;
            case 4: $('#view-name').html("Event");
                break;
        }

        $.post("utilities\\loadList.php", { option: viewOption },
            function (data) {
                $('#list').html(data);
            }
        );
    }

});