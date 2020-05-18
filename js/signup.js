console.log("signup.js included");

function checkUsernameAvailability(username) {
    console.log(username);

    var data = {
        'action' : 'checkUsernameAvailability',
        'username' : username
    };

    $.ajax({
        url: 'ajax.php',
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function(data) {
            console.log(data);
            $('#username-check-message').removeClass(" error");
            $('#username-check-message').removeClass(" success");
            $('#username-check-message').html(data.msg);
            if(data.success == true) {
                $('#username-check-message').addClass(" success");
            } else { 
                $('#username-check-message').addClass(" error");
            }
            $('#username-check-message').css("display","block");
        },
        error:function(error,status) {
            $('#username-check-message').removeClass(" error");
            $('#username-check-message').removeClass(" success");
            $('#username-check-message').html(error.responseText);
            if(data.success == true) { 
                $('#username-check-message').addClass(" success");
            } else {
                $('#username-check-message').addClass(" error");
            }
            $('#username-check-message').css("display","block");
        }
    });
}

function checkFieldsIfBlank() {
    $.each($('.form-field'),function(i, val) {
        var content = val.querySelector('input').value;
        // querySelector selects the first of the type of the selector used from the DOM of elemennt on which it is used (here val)
        if(content == '') {
            var a = val.querySelector('p');
            a.classList.add("error");
            a.style.display = "block";
            a.innerHTML = val.querySelector('label').innerHTML + " cannot be blank";
        }
    });
}

function makeAccount(username, name, email, password) {
    event.preventDefault();
    console.log("makeAccount called");
    
    var a = $('.form-field > p.error');
    if(a.length != 0) {
        $('#register-response-message').html("Please fill the form completely.");
        $('#register-response-message').css("display","block"); return;
    }

    var data = {
        'action' : 'makeAccount',
        'username' : username,
        'name' : name,
        'email' : email,
        'password' : password
    };

    $.ajax( {
        url: 'ajax.php',
        dataType: 'json',
        data: data,
        method: 'POST',
        success:function(data){
            console.log(data);
            $('#register-response-message').html(data.msg);
            if(data.success == 1) { 
                console.log("Success");
                $('#register-response-message').removeClass("error"); 
                $('#register-response-message').addClass("success"); 
                $('#register-response-message').html(data.msg); 
                $('#register-response-message').css("display","block"); 
                // window.location.href = "./dashboard.php";                        
                // // change later to dahsboard
                // location.reload(true);
                
            
            } else if(data.success == -1) { 
                $('#register-response-message').css("display","block");
                $('input[name="'+data.errorField+'"] ~ p').html(data.errorMsg);
                $('input[name="'+data.errorField+'"] ~ p').css("display","block");
                $('input[name="'+data.errorField+'"] ~ p').addClass("error");
            
            } else { 
                $('#register-response-message').css("display","block");
            }
        },
        error:function(error) { 
            $('#register-response-message').html(error.responseText);
            $('#register-response-message').css("display","block");
        }
    });
    var timer = setTimeout(function() {
        window.location='./index.php'
    }, 3000);
    // location.reload(true);
}



