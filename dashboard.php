<?php
    session_start();
    $title = "Dashboard | ExpendiShare";
    include_once('components/header.php');
?>
<div class="container flex">

    <!-- Left Sidebar-->
    <aside class="sidebar">
        <h2>Your Friends</h2>
        <div id="display">
        </div>
    </aside>

    <!-- Main container -->
    <section class="main">
        <div class="container row">
            <h2>Main Dashboard</h2>
            <button id = "add-expense-btn"class="btn">Add Expense</button>
            <button class="btn">Show Expenses</button>
        </div>
        <div class="container" id ="add-expense">
            <div class="col">
                <h2>Add Expense</h2>
                <div class="form-field col">
                    <label> Amount </label>
                    <input type="number" name="amount" id="amountBox" max-length="10" required>
                    <span><input type="radio" name="splittype" value="youpaidsplitequally">You paid, Split equally</span>
                    <span><input type="radio" name="splittype" value="friendpaidsplitequally">Friend paid, Split equally</span>
                    <span><input type="radio" name="splittype" value="friendowecomplete">Friend owes complete amount</span>
                    <span><input type="radio" name="splittype" value="youowecomplete">You owe complete amount</span>
                </div> <br>
                <div class="form-field">
                    <label> Category </label>
                    <input type="text" name="category" id="categoryBox" max-length="50" size="50" required>
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
            
        </aside>
</div>

<script>
    $(document).ready(function() {
        $('#add-expense').hide();
        $('#add-expense-btn').click(function () {
            $('#add-expense').toggle();
        });
    });
    
</script>
<?php
    include_once('components/footer.php');
?>