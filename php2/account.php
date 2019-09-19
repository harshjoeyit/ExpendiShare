<?php

session_start();
include('connect.php');
error_reporting(0);

$user_email = $_SESSION['email'];

if( $user_email == true )
{
    $query = "SELECT * FROM users_info WHERE email = '$user_email' ";
    $data = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($data);

    $name = $result['name'];
    $profile_pic = $result['profile_pic'];

}
else
{   
    header('location: ../html/login.html'); 
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account | ExpendiShare</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/account.css">
</head>

<body>
    <!--Navigation Bar-->
    <header>
        <h1 class="logo">ExpendiShare</h1>
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

    <!-- for update message -->
    <!-- seperate styles design message box-->
    <div id = "message" style = "color: white; background: black; text-align: center; width: 500px; margin: auto;"><?php echo $_GET['msg'] ?></div>

    <!-- user profile pic display -->
    <div id="page">
        <div id ="pic">
            <img src ='<?php echo $profile_pic; ?>' alt = '<?php echo $name."'s profile picture"; ?>'  />
            <form action="../php2/upload_profile.php" method="post" enctype= "multipart/form-data">
                <input class ="image" type="file" name= "uploadfile" value = "" />
                <input class ="image" type="submit" name="submit" value="Upload" />
            </form>
        </div>
            

<!-- update user details form for ----   name and email-->

            <form action="update.php" method="POST">
                <!-- name change  -->
                <h2><?php echo $name; ?></h2>
                <button id = "editname">Edit</button>
                <div id = "nameform">
                    <input type="text" name="name" placeholder="New Name">
                    <button id = "canceleditname">Cancel</button>
                </div>
                <!-- email change -->
                <p><?php echo $user_email; ?></p>
                <button id = "editemail">Edit</button>
                <div id = "emailform">
                    <input type="email" name="email" placeholder="New Email">
                    <button id = "canceleditemail">Cancel</button>
                </div>
                <!-- seperate styles -->
                <br><br><label style="display: block;"   for="password">Update Password</label>
                <button id = "editpassword">Edit</button>
                <div id = "passwordform">
                    <input type="password" name="oldpassword" placeholder="Old Password">
                    <input type="password" name="newpassword" placeholder="New Password">
                    <button id = "canceleditpassword">Cancel</button>
                </div>
                <!-- seperate styles -->
                <br><br><br><br><div>
                    <input style="display: block; float:right; margin: 10px;"type="submit" name = "Update" value = "Update">
                </div>
            </form>

    </div>
    
    <script src = "../js/jquery-3.4.1.js"></script>
    <script src="../js/account.js"></script>
    <script src="./js/nav-mobile.js"></script>
</body>   
</html>
