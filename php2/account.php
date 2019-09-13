<?php

session_start();
include('connect.php');
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
    
    <div id="page">
        <div id ="pic">
            <img src ='<?php echo $profile_pic; ?>' alt = '<?php echo $name."'s profile picture"; ?>'  />
            <form action="../php2/upload_profile.php" method="post" enctype= "multipart/form-data">
                <input class ="image" type="file" name= "uploadfile" value = "" />
                <input class ="image" type="submit" name="submit" value="Upload" />
            </form>
            <h2><?php echo $name; ?></h2>
            <form action="update.php" method="POST">
                <button>Edit</button>
                <input type="text" name="name" placeholder="Name">
                <button>Cancel</button>
                <input type="submit" name = "submit" value = "Change name">
            </form>
        </div>
    </div>
    
    <script src = "../js/jquery-3.4.1.js"></script>
    <script src="../js/account.js"></script>
    <script src="./js/nav-mobile.js"></script>
</body>   
</html>
