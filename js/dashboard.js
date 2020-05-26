console.log("Dashboard.js included");

var username = $('#user-profile').html();
console.log(username);

$('#user-profile').on('click', function() {
    console.log("clicked");
});

$('#display-friends').on('click','li', function() {
    console.log(this.textContent);
});

/* ---------- Display Friends ---------- */
function displayFriends(username) {
    $.ajax({
        url: "ajax.php",
        method: "POST",
        dataType: "json",
        data: {'display' : username},
        success: function(data) {
            console.log("Display friends data recieved");
            // console.log(data);
            var html = "";
            for(var i = 0; i < data['friends'].length; i++) {
                html += "<li>" + data['friends'][i] + 
                "</li>"
            }
            $('#display-friends').html(html);

        },
        error: function(error, status) {
            console.log(status);
            // console.log(error);
        }
    });
}
/* ---------- Live Search ---------- */
function liveSearch() {
    function load_data(search) {
        $.ajax({
            url: "ajax.php",
            method: "POST",
            dataType: "json",
            data: {'search' : search},
            success: function(data) {
                console.log("Friends suggestions retrieved");
                if(data['status'] == 1) {
                    var html = "";
                    for(var i = 0; i < data['users'].length; i++) {
                        html += "<li>" + data['users'][i] + "</li>"
                    }
                    $('#searchResults').html(html);
                } else {
                    $('#searchResults').html(data['msg']);
                }
            },
            error: function (error, status) {
                // console.log(error);
                console.log(status);
                console.log("some error occured");
            }
        });
    }
    $("#searchFriends").keyup(function() {
        var search = $(this).val();
        if(search != '') {
            load_data(search);
        } else {
            $('#searchResults').html('');
        }
    });
}

/* --------------- Add Friends ---------------------- */
function addFriend(username, friend) {
    var successMessage = $('#success-message');
    var showError = $('#add-response-message');

    // Validation

    if(friend.length == 0) {
        showError.css('display', 'block');
        showError.html("No name entered");
        return;
    } else {
        showError.css('display', 'none');
    }
    console.log(username);
    console.log(friend);


    var data = {
        'action' : 'addFriend',
        'username' : username,
        'friend' : friend
    };

    $.ajax({
        url: 'ajax.php',
        dataType: 'json',
        data: data,
        method: 'POST',
        success: function(data) {
            
            successMessage.css('display', 'block');
            successMessage.html(data.msg);

            if(data.status == 1) {
                successMessage.css('color', 'green');
                displayFriends(username);
            } else if(data.status == 0) {
                successMessage.css('color', 'red');
            } else if(data.staus == -2) {
                successMessage.css('color', 'red');
            } else {
                successMessage.css('color', 'orange');
            }
            successMessage.delay(1000).fadeOut(500);
            $('input[name="friend"]').val('');
        },
        error: function (error) {
            successMessage.css('display', 'block');
            successMessage.html('some error occurred');
            successMessage.css('color', 'red');
            successMessage.delay(1000).fadeOut(500);
            $('input[name="friend"]').val('');
        }
    });
}

function displayFriendsInExpenseForm(username) {
    $.ajax({
        url: "ajax.php",
        method: "POST",
        dataType: "json",
        data: {'display' : username},
        success: function(data) {
            console.log("Display friends data recieved");
            // console.log(data);
            var html = "";
            for(var i = 0; i < data['friends'].length; i++) {
                html += "<input name='withfriends' type='checkbox' value='" + data['friends'][i] + "'>" + data['friends'][i] + 
                "</input>" + "<br>"
            }
            
            html += '<button type="submit" id="select-frnds-btn" class="btn">Save</button>';
            $('#select-frnd-content').html(html);

        },
        error: function(error, status) {
            console.log(status);
            // console.log(error);
        }
    });
}

function displaySplitingTypes() {
    $.ajax({
        url : "ajax.php",
        method: "POST",
        data: {'action' : 'displaySplitingTypes'},
        dataType: "json",
        success: function(data) {
            // console.log(data);
            var html = "";
            // console.log(data[0]);
            for(var i = 0; i < data.length; i++) {
                html +=
                "<option name='splittype' value='" + data[i]['spliting_type_id'] + "'>" + data[i]['spliting_type_name'] + "</option>";
            }
            $('#select-split-type').html(html);
        },
        error: function(error, status) {
            console.log(status);
        }
    });
}

$(function(){
    $('#select-split-type').change(function() {
        var splitType = $('#select-split-type option:selected').val();
        console.log(splitType);
    });
});
