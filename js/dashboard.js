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
            console.log(data);
            for(var i = 0; i < data['friends'].length; i++) {
                console.log(data['friends'][i]);
                var html = "<li>" + data['friends'][i] + 
                "</li>"
                console.log(html);
                $('#display-friends').append(html);

            }
        },
        error: function(error, status) {
            console.log(error);
        }
    });
}