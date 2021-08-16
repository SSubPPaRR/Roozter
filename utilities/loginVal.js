$(document).ready(function () {
    $("#form").submit(function (e) { 
      e.preventDefault();
      var username = $("#username").val();
      var password = $("#psw").val();
      
      $("#failed-login-msg").load("utilities\\loginVal.php",{
        Username:username,
        Password:password,
        Submit: 0
      },
    function(){
            $.post("utilities\\loginVal.php",{
                Username:username,
                Password:password,
                Submit: 1
            },  function (data, textStatus) {
                    console.log(data);
                    if(data>0){
                      location.reload(true);  
                    }
                }
            );
        });
    });
  });
