<?php
 
    include("connect.php");
    error_reporting(0);
?>

<div class="main">
    <div class="wrapper-main">
        <section class="section-default">
           
            <?php
                $selector = $_GET['selector'];
                $validator = $_GET['validator'];

                if(empty($selector) || empty($validator))
                {
                    echo "could not validate request";
                }
                else
                {
                    if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) != false)
                    {
                        ?>

                        <form action="reset-password.inc.php" method = "post">
                            <input type="hidden" name = "selector" value = "<?php echo $selector?>" >
                            <input type="hidden" name = "validator" value = "<?php echo $validator?>" >
                            <input type="password" name = "pwd" placeholder = "new password">
                            <input type="password" name = "pwd-repeat" placeholder="confirm new password">
                            <button type="submit" name ="reset-password-submit" >Reset Password</button>

                        </form>                        

                        <?php

                    }

                if(isset($_GET['newpwd']))
                {
                
                    echo '<p class = "msg">'.$_GET['newpwd'].'</p>';
                
                }
                }
            ?>

        </section>
    </div>
</div> 