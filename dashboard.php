<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: ./index.php");
    }
    $title = "Dashboard | ExpendiShare";
    include_once('components/header.php');
?>
<div class="container flex">

    <!-- Left Sidebar-->
    <aside class="sidebar">
        <div class="sidebar-widget">
            <h2 class="widget-title">My Friends</h2>
            <!-- <input class="hello"type="checkbox" value="hello">Hello</input> -->
            <div id="display-friends"></div>
        </div>

        <div class="sidebar-widget">
            <h2 class="widget-title">My Groups</h2>
            <!-- <input class="hello"type="checkbox" value="hello">Hello</input> -->
            <div id="display-grp"></div>
        </div>
        
    </aside>
    

    <!-- Main container -->
    <section class="main">
        <div class="container row">
            <h2>Main Dashboard</h2>
            <button id = "add-expense-btn"class="btn">Add Expense</button>
            <button id = "show-expenses-btn" class="btn">Show Expenses</button>
        </div>
        <div class="show-expense">
            <div class="row">
                <div>
                    <h3>You Owe</h3>
                </div>
                <div>
                    <h3>You Paid</h3>
                </div>
            </div>
        </div>
        <div class="container" id ="add-expense">
            <div class="col">
                <h2>Add Expense</h2>
                <div class="form-field select">
                    <label>Select Expense Type</label>
                    <select class = "select-expense-type">
                        <option name="expensetype" selected value="selectexpensetype" disabled>Select Expense Type</option>
                        <option name="expensetype" value="1">Individuals</option>
                        <option name="expensetype" value="2">Group</option>
                    </select>
                </div><br>
                <div class="form-field select" id="select-group">
                    <label>Select Group</label>
                    <select class = "group-data">
                        <option name="expensetype" selected value="selectexpensetype" disabled>Select Expense Type</option>
                        <option name="expensetype" value="1">Individuals</option>
                        <option name="expensetype" value="2">Group</option>
                    </select>
                </div>
                <div class="form-field row" id = "splitingmembers" style="justify-content: center">
                    <span>With:</span>
                    <span id = "membersname"></span>
                    <button id="chose-frnd-btn"class="btn">Select</button>
                    <div id="select-frnd" class="modal">
                        <div class="modal-form">
                            <h2>Select Friends</h2>
                            <div id = "select-frnd-content" class="modal-content">
                            
                            </div>
                            <div class="modal-close-btn">X</div>
                        </div>
                    </div>
                </div>

                <div class="form-field select">
                    <label>Select Spliting Type</label>
                    <select id = "select-split-type">
                    </select>
                </div><br>
                <div class="form-field select friendpaid" style="display: none;">
                    <label>Who paid</label>
                    <select id = "whopaid">
                    </select>
                </div>

                <div class="modal" id="custom-split">
                    <div class="modal-form" id="custom-split-form">
                        <h2>Custom splitting</h2>
                        <div id="custom-split-content" class="modal-content grid-container">
                        </div>
                        <div class="modal-close-btn">X</div>
                    </div>
                </div>

                <div class="form-field col">
                    <label> Amount </label>
                    <input type="number" name="amount" id="amountBox" max-length="10" required>
                </div> <br>
                
                    
                <div class="form-field select">
                    <label> Category </label>
                    <select class="select-expense-category">
                        <option name="expensecategory" selected disabeld>Select Category</option>
                        <?php
                            include_once('class.misc.php');
                            $misc = new misc();
                            $categorys = $misc->getExpenseCategory();
                            foreach($categorys as $category) {
                        ?>
                        <option name="expensecategory" data-id="<?php echo $category[1];?>"><?php echo $category[0]; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                    <!-- <input type="text" name="category" id="categoryBox" max-length="50" size="50" required> -->
                    

                </div><br>
                <div class="form-field">
                    <label> Description </label>
                    <input type="text" name="description" id="description" max-length="50" size="50">
                </div><br>
                <p id="split-success-message" style="display: none;">Success message</p>
            </div>
            <button id="split" class="btn">Split</button>
        </div>
        
    </section>

    <!-- Right sidebar -->
    <aside class = "sidebar">
        <div class="sidebar-widget">
            <h2 class="widget-title">Add Friends</h2>
            <div class="widget-field">
                <label>Friend Username</label>
                <input name="friend" id="searchFriends" type="text" style="text-transform:lowercase" max-length="40" required>
            </div>
            <p id="add-response-message" class="error"></p>
            <div>
                <button id="add" class="btn"> Add </button>
            </div>
            <p id="success-message" style="display: none;">Success message</p>
            <br>
            <div id="searchResults"></div>
        </div>

        <div class="sidebar-widget">
            <h2 class="widget-title">Create Group</h2>
            <div class="widget-field">
                <label>Group Name</label>
                <input name="groupname" id="create-grp" type="text" style="text-transform:lowercase" max-length="40" required>
            </div>
            <p id="add-response-message-create-grp" class="error"></p>
            <div>
                <button id="create-grp-btn" class="btn"> Create </button>
            </div>
            <div class="modal" id="create-grp-modal">
                <div class="modal-form" id="create-grp-modal-from">
                    <h2>Select Members</h2>
                    <div id="create-grp-content" class="modal-content">
                    </div>
                    <div class="modal-close-btn">X</div>
                </div>
            </div>
            <p id="success-message" style="display: none;">Success message</p>
            <br>
            <!-- <div id="searchResults"></div> -->
        </div>
        <!-- <div class="btn" id="checked">Hello</div> -->
            
    </aside>
</div>
<script>
    $(document).ready(function() {

        var username = "<?php echo $_SESSION['user']; ?>";

        displayFriends(username);
        displayGroups(username);

        liveSearch();
        spliting();

        $('#add-expense').hide();
        $('.show-expense').hide();
        $('#select-group').hide();

        $('#add-expense-btn').click(function () {
            $('.show-expense').hide();
            $('#add-expense').toggle();
            displaySplitingTypes();
        });

        $('#show-expenses-btn').click(function () {
            $('#add-expense').hide();
            $('.show-expense').toggle();
        });

        $('#add').on('click', function(e) {
            e.preventDefault();
            var friend = $('input[name="friend"]').val();
            console.log(friend);
            addFriend(username, friend);
        });
    
        $('.modal-close-btn').on('click', function() {
            $('.modal').hide();
        });


        $('#create-grp-btn').on('click', function() {
            console.log("create grp clicked");
            var msg = $('#add-response-message-create-grp').text();

            if(msg == "Available") {
                var grpName = $('input[name="groupname"]').val();
                var members = [];
                console.log(grpName);
                if(grpName == "") {
                    $('#add-response-message-create-grp').html("Group Name cannot be blank");
                } else {
                    $('#create-grp-modal').show();

                    displayFriendsInModalForm(username, "create-grp");
                    $('#create-grp-modal').on('click', '#create-grp-btn', function() {
                        console.log("Selected Members data retrived");
                        $('#create-grp-content input[type="checkbox"]').each(function() {
                        var member = $(this);
                        if(member.is(":checked")) {
                            members.push(member.val());
                        }
                        });
                        $('#create-grp-modal').hide();
                        // console.log(members);
                        createGroup(grpName, members);
                        displayGroups(username);

                    });
                }
            }
        }); 
    });
    
</script>
<script src = "./js/dashboard.js"></script>

<?php
    include_once('components/footer.php');
?>