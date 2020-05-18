<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header("Location: ./dashboard.php");
    }
    $title = "Login | ExpendiShare";
    include_once('components/header.php');
?>
<div class="container">
    <section class="form">
        <p id = "login-response-message"></p>
        <div class="form-field">
            <label>Username</label>
            <input name = "username" type = "text" required>
            <p id = "username-check-message" class = "error"></p>
        </div>
        <div class="form-field">
            <label>Password</label>
            <input name = "password" type = "password" required>
        </div>
        <p><a href = "forgot_password" >Forgot Password?</a></p>
        <div style = "width: 100%;">
            <button id = "login-btn" class = "btn">Log In</button>
            <div style ="display:inline-block;padding-left:2%;"><a href = "signup.php">Sign Up</a></div>
        </div>
    </section>
</div>

<?php
    include_once('components/footer.php');
?>