<?php
 
    include("connect.php");
    error_reporting(0);
?>

<div class="main">
    <div class="wrapper-main">
        <section class="section-default">
            <h1>Reset Your Password</h1>
            <p>An email will be send to you with the instructions to reset the password</p>
            <form action="reset-request.inc.php" method = "post">
                <input type="email" name = "email" placeholder= "E-mail">
                <button type="submit" name = "reset-request-submit" > Reset </button>
            </form>

            <?php
                if(isset($_GET['reset']))
                {
                    if($_GET['reset'] == 'success')
                    {
                        echo '<p class = "msg"> Check Your Email</p>';
                    }
                }
            ?>
        </section>
    </div>
</div> 