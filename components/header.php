<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <div class="container flex navbar">
            <div class="site-title">
                <h1 class="logo">ExpendiShare</h1>
                <p class="tagline">An interactive way of splitting bills</p>
            </div>
            
            <nav>
                <ul class="flex">
                    <?php
                        if(isset($_SESSION['user'])) {
                    ?>
                    <li><a href="#"><?php echo $_SESSION['user']; ?></a></li>
                    <?php
                        } else {
                    ?>
                    <li><a href="/ExpendiShare/">Home</a></li>

                    <?php
                        }
                    ?>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <?php
                        if(isset($_SESSION['user'])) {
                    ?>
                    <li><a href="logout.php" class="btn">Logout</a></li>
                    <?php
                        } else {
                    ?>
                    <li><a href="login.php" class="btn">Login</a></li>
                    <?php
                        }
                    ?>

                </ul>
            </nav>
        </div>
    </header>