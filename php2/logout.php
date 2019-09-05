<?php
    session_start();
?>



<?php

    session_unset();
    header('location: ../html/login.html');
?>