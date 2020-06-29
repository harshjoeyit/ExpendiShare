<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: ./index.php");
    }
    $title = "My Profile | ExpendiShare";
    include_once('components/header.php');

    $name = $_SESSION['user'];
    $user_email = "";
?>
<div class="container">
    <h1>My Profile</h1>
    <div class="flex">
        <div class="container">
            <h1>Profile Pic</h1>
        </div>
        <div class="container">
            <div class="row">
                <h2><?php echo $name; ?></h2>
                <button class ="btn" id = "editname">Edit</button>
            </div>
            
            <div id = "nameform" class="flex" style="justify-content: space-between">
                <input type="text" name="name" placeholder="New Name">
                <button class ="btn" id = "canceleditname">Cancel</button>

            </div>

            <!-- email change -->
            <div class="row">
                <p><?php echo $user_email; ?></p>
                <button class ="btn" id = "editemail">Edit</button>
            </div>
            
            <div id = "emailform" class="flex" style="justify-content: space-between">
                <input type="email" name="email" placeholder="New Email">
                <button  class ="btn" id = "canceleditemail">Cancel</button>
            </div>
            <!-- seperate styles -->
            <div class="row">
                <label style="display: block;"   for="password">Update Password</label>
                <button  class ="btn" id = "editpassword">Edit</button>
            </div>
            
            <div id = "passwordform" class="flex" style="justify-content: space-between">
                <input type="password" name="oldpassword" placeholder="Old Password">
                <input type="password" name="newpassword" placeholder="New Password">
                <button class ="btn"id = "canceleditpassword">Cancel</button>
            </div>
            <!-- seperate styles -->
            <br>
            <div>
                <input type="submit" class ="btn" name = "Update" value = "Update">
            </div>
        </div>
    </div>
</div>
<script src='./js/profile.js'></script>
<?php
    include_once('components/footer.php');
?>