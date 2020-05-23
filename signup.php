<?php
    session_start();                               
     // Note: The session_start() function must be the very first thing in your document. Before any HTML tags.
    if(isset($_SESSION['user'])) {
        header('Location: ./dashboard.php');        // change for .htaccess     
    }
    if(isset($_SESSION['user'])) {
        ob_start();
    }
    $title = "Sign Up | ExpendiShare";
    include_once('components/header.php');
?>

<div class="container">
    <form>
    <section class="form">
        <p style="color: orange">page not reloading after succesfull signup</p>
        <div class="form-field">
            <label>Username</label>
            <input name="username" type="text" style="text-transform:lowercase" max-length="40" required>
            <p id="username-check-message" class="error"></p>
            <!-- <p id="demo" class="error"></p> -->
        </div>
        <div class="form-field">
            <label>Name</label>
            <input name="name" type="text" max-length="50" required>
            <p id="name-check-message" class="error"></p>
        </div>
        <div class="form-field">
            <label>Email</label>
            <input name="email" type="email" max-length="50" required>
            <p id="email-check-message" class="error"></p>
        </div>
        <div class="form-field">
            <label>Password</label>
            <input name="password" type="password" required>
            <p id="password-check-message" class="error"></p>
        </div>
        <p id="register-response-message" class="error"></p>
        <div>
            <button id="make-account" class = "btn">Sign Up</button>
        </div>
        <br>
        <div><a href="login.php">Have an account?</a></div>
    </section>
    </form>
</div>
<script src="./js/signup.js"></script>
<script>
    
    $(document).ready(function() {
    
        $('.form-field > input').on('keyup', function(e) {
            if(e.which == 13)
                return;
            $(this).next().removeClass("error");
            // next() - for selecting the next element
            $(this).next().css("display", "none");
        });
        $('input[name="username"]').on("keyup", function() {
            var username = $('input[name="username"]').val();
            // console.log(username);
            checkUsernameAvailability(username);
        });
        $("#make-account").on('click', function() {
            checkFieldsIfBlank();

            var username = $('input[name = "username"]').val();
            var name = $('input[name = "name"]').val();
            var email = $('input[name = "email"]').val();
            var password = $('input[name = "password"]').val();
            makeAccount(username, name, email, password);
        });
    });
</script>
<?php
    include_once('components/footer.php');
?>