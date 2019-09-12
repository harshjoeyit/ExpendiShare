<?php

session_start();
include('connect.php');
//   identifying the user by his email since it is primary key  
$user_email = $_SESSION['email'];

// no one can access the personal dashboard by just pressing the back button or by url itself
// if user has logged in and not just typing the address of the dashboard.php
if( $user_email == true )
{
    $query = "SELECT * FROM users_info WHERE email = '$user_email' ";
    $data = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($data);

    $name = $result['name'];
    $profile_pic = $result['profile_pic'];

}
else
{   // if the user has not logged in ad tries to access the home.php
    header('location: ../html/login.html'); 
}

?>




<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | ExpendiShare</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/dash.css">
</head>

<body>
    <!--Navigation Bar-->
    <header>
        <h1 class="logo">ExpendiShare</h1>
        <!-- seperate the styles  -->
        <div class="crop">
            <img style="border-radius:35px;" src =  '<?php echo $profile_pic; ?>' alt = '<?php echo $name."'s profile picture"; ?>'  />
        </div>
        <a href="account.php">My Account</a>
        <!-- bring the username and the profile picture closer -->
        <h3><?php echo $name; ?></h3>
        <nav>
            <ul class="nav-links">
                <li ><a class="active" href="../index.html">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <a class="cta" href="../php2/logout.php" onclick="return confirm('Are you sure to logout?')"><button>Log Out</button></a>
        <a class="menu">&#9776;</a>
    </header>
    <section class="main-content">
        <div class="container">
            <h2>Welcome</h2>
            <hr>
        </div>
    </section>
    <aside>
        <h2>Search Friend</h2>
        <hr>
        <form>
            <input type="email" name="email" placeholder="Friend's Email*" required>
            <input class="button" type="submit" name = "search" value="search">
        </form>
        <h2>Invite Friend</h2>
        <hr>
        
        <form action = "../php2/email_invite.php" method = "post" ">
            <input type="email" name="email" placeholder="Friend's Email*" required>
            <input class="button" type="submit" name = "send" value="send">
            <!-- <div id = "msg">send mail status</div> -->
        </form>
    </aside>
    <script src = "../js/jquery-3.4.1.js"></script>
    <script src="../js/dashboard.js"></script>
</body>   
</html>






