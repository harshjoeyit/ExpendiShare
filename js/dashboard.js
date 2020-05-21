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
            for(var i = 0; i < data['friends'].length; i++) {
                var html = "<li>" + data['friends'][i] + 
                "</li>"
                $('#display-friends').append(html);

            }
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
