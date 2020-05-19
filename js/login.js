console.log("Login.js is called");

function check(e) {
    console.log("checking on!");
    if(e.which == 13) return;

    $('#username-check-message').removeClass(" error");
    $('#username-check-message').removeClass(" success");
    $('#username-check-message').css("display", "none");
}

function logIn(username, password) {
    var data = {
        'action' : 'login',
        'username' : username,
        'password' : password
    };

    $.ajax({
        url: 'ajax.php',
        dataType: 'json',
        data : data,
        method : "POST",
        success:function(data) {
            if(data.success == true) {
                $('#username-check-message').addClass(" success");
                $('#username-check-message').html(data.msg);
                $('#username-check-message').css("display","block");
                 window.location.href = "./dashboard.php";                   // change
            } else {
                $('#username-check-message').addClass(" error");
                $('#username-check-message').html(data.msg);
                $('#username-check-message').css("display","block");
            }
        },
        error:function(error,status){
            $('#username-check-message').html(error);
            $('#username-check-message').css("display","block");
        }
    });
}