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

function displayFriendsInModalForm(username, modalBoxId) {
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
            
            html += '<button type="submit" id="' + modalBoxId + '-btn" class="btn">Save</button>';
            var selector = "#"+ modalBoxId +"-content";
            $(selector).html(html);

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
            var html = "<option name='splittype' value='0' selected disabled>Select the spliting type</option>";
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

/*-----------------------------ADD EXPENSE --------------------- */

function addExpense(username, expenseType, splitType, friends, amount, category, description, whoPaid) {

    var data;
    console.log(friends);
    // Individual Expenses
    if(expenseType == 1) {
        data = {
            'action': 'addIndividualExpense',
            'username' : username,
            'splitType' : splitType,
            'members' : friends,
            'amount' : amount,
            'description' : description,
            'category' : category,
            'whoPaid' : whoPaid
        };
    }

    $.ajax({
        url: 'ajax.php',
        dataType: 'json',
        data : data,
        method: 'POST',
        success: function(data) {
            console.log("succes");
            console.log(data);
        },
        error: function(error, status) {
            console.log(status);
            console.log(error);
        }
    });
}

function addCustomExpense(username, expenseType, friends,amount, owedAmount,expenseCategory, description) {
    var data = {
        'action': 'addIndividualCustomExpense',
        'username' : username,
        'splitType' : 5,
        'members' : friends,
        'amountPaid' : amount,
        'owedAmount': owedAmount,
        'description' : description,
        'category' : expenseCategory,
        'whoPaid' : username,
    };

    $.ajax({
        url: 'ajax.php',
        dataType: 'json',
        data : data,
        method: 'POST',
        success: function(data) {
            console.log("succes");
            console.log(data);
        },
        error: function(error, status) {
            console.log(status);
            console.log(error);
        }
    });
    
}


function spliting() {
    var friends = [];
    var owedAmount = []; //use only in case of custom split

    $('#chose-frnd-btn').on('click', function() {
        $('#select-frnd').show();
        var type = $('.select-expense-type option:selected').val();
        if(type == 1) {
            displayFriendsInModalForm(username, "select-frnd");
            $(document).on('click','#select-frnds-btn', function(){
                console.log("Selected data retrived");
                var html = "";
                $("#select-frnd-content input[type='checkbox']").each(function() {
                    var member = $(this);
                    if(member.is(":checked")) {
                        // console.log(member.val());
                        html += "<li>" + member.val() + "</li>";
                        friends.push(member.val());
                    }
                });
                $('#select-frnd').hide();
                $('#membersname').html(html);
                console.log(friends);
            });
        }
    });
    
    $(function(){
        $('#select-split-type').change(function() {
            var splitType = $('#select-split-type option:selected').val();
            console.log(splitType);
            if(splitType == 1) {
                $('.friendpaid').hide();
            } else if(splitType == 2 && friends.length >= 2) {
                
                $('.friendpaid').show();
                var html = "";
                for(var i = 0; i < friends.length; i++) {
                    html +="<option name='friendpaid'>"+ friends[i]+"</option>" 
                }
                $('#whopaid').html(html);
            } else {
                $('.friendpaid').hide();
            }
            if(splitType == 5) {
                $('#custom-split').show();
                var html = "<label><h3>Name</h3></label><label><h3>Owed</h3></label>";
                for(var i = 0; i < friends.length; i++) {
                    html += "<label>"+ friends[i] +"</label>";
                    html += "<input type='number' name='custom-split-amount'style='width: 50px; border: 1px solid black;'>";
                }
                html += "<button id='custom-split-btn'class='btn'>Save</button>";
                $('#custom-split-content').html(html);
            }
        });

        $('#custom-split').on('click', '#custom-split-btn', function() {
            console.log("Clicked");
            $('input[name="custom-split-amount"]').each(function() {
                
                var x = $(this).val();
                if(x == "")
                    x = 0;
                owedAmount.push(Number(x));
            });
            console.log(owedAmount);
            $('#custom-split').hide();
        });
    });

    $('#split').on('click', function() {
        var expenseType = $('.select-expense-type option:selected').val();
        var splitType = $('#select-split-type option:selected').val();
        var amount = $('#amountBox').val();
        var expenseCategory = $('.select-expense-category option:selected').data('id');
        var description = $('input[name="description"]').val();
        var whoPaid = username;

        if(splitType == 2) {
            whoPaid = $('#whopaid option:selected').val();
        }
        
        console.log(expenseType);
        console.log(splitType);
        console.log(amount);
        console.log(expenseCategory);
        console.log(description);
        console.log(whoPaid);
        if(expenseType == 1) {
            if(splitType != 5) {
                addExpense(username, expenseType, splitType, friends, amount, expenseCategory, description, whoPaid);
            }
            if(splitType == 5) {
                addCustomExpense(username, expenseType, friends,amount, owedAmount,expenseCategory, description);
            }
        }
        


    });
}

/*--------------------------Groups ----------------------------- */

// $('#create-grp').keyup(function() {
//     var grpName = $('input[name="groupname"]').val();
//     console.log(grpName);
//     // console.log("hello");
// });



/*--------------------- Create Group --------------------------- */

// $('#create-grp-btn').on('click', function() {
//     console.log("create grp clicked");
//     var grpName = $('input[name="groupname"]').val();
//     console.log(grpName);
//     createGroup(grpName);
// });



function createGroup(groupname, members) {
    console.log(groupname);
    console.log(members);

    var data = {
        'action' : 'addGroup',
        'groupMembers' : members,
        'groupname' : groupname,
        'username' : username 
    };

    $.ajax({
        url: 'ajax.php',
        dataType: 'json',
        data: data,
        method: 'POST',
        success: function(data) {
            console.log(data);
        },
        error: function(error, status) {
            console.log(status);
        }
    });
}