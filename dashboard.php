<?php
    session_start();
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
                <input name="friend" id="create-grp" type="text" style="text-transform:lowercase" max-length="40" required>
            </div>
            <p id="add-response-message" class="error"></p>
            <div>
                <button id="create-grp-btn" class="btn"> Create </button>
            </div>
            <p id="success-message" style="display: none;">Success message</p>
            <br>
            <!-- <div id="searchResults"></div> -->
        </div>
        <!-- <div class="btn" id="checked">Hello</div> -->
            
    </aside>
</div>
<script src = "./js/dashboard.js"></script>
<script>
    $(document).ready(function() {

        var username = "<?php echo $_SESSION['user']; ?>";

        displayFriends(username);
        liveSearch();
        spliting();

        $('#add-expense').hide();
        $('.show-expense').hide();

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
    });
    
</script>
<?php
    include_once('components/footer.php');
?>