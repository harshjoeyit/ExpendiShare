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
        <div class="crop">
            <img style="border-radius:35px;" src =  '<?php echo $profile_pic; ?>' alt = '<?php echo $name."'s profile picture"; ?>'  />
        </div>
        <a href="account.php"><h3><?php echo $name; ?></h3></a>
        
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
    
    <!--Left Contain-->
    
    <aside class="left-container">
        <div class='tab'>
            <button><a href = "dashboard.php"><h2>Dashboard<h2></a></button>
        </div>

        <div><h2>Friends</h2></div>
        <hr>
        <?php
            
            $user_id = $result['user_id'];

            $search_query = "SELECT * FROM friends_info WHERE user_id = '$user_id'";
            $search_data = mysqli_query($conn, $search_query);
            $search_rows = mysqli_num_rows($search_data);
            if($search_rows){
                $search_result = mysqli_fetch_assoc($search_data);
                $friends_id = $search_result['friends_id'];
                $friends_id_array = unserialize($friends_id);
            
                foreach($friends_id_array as $x => $x_value)
                {
                
                    $find_name_query = "SELECT * FROM users_info WHERE user_id = '$x_value'";
                    $find_name_data = mysqli_query($conn, $find_name_query);
                    $find_name_result = mysqli_fetch_assoc($find_name_data);

                    $friend_name = $find_name_result['name'];
                

                    //Tab Layout for Friends Display

                    echo "<div class='tab'>
                            <button><a  style='color: #011627; font-size: 22px; padding-left: 10px' href = 'expense.php?group_id=0&friend_id=$x_value' >".$friend_name."</a></button>
                            </div>";
                }
            }
            
        ?>
        <a href="#"><button class="split-with-friends">Split with Friends</button></a>
        <div><h2>Groups</h2></div>
        <hr>
        <?php
            $search_query = "SELECT * FROM grps_info WHERE user_id = '$user_id'";
            $search_data = mysqli_query($conn, $search_query);

            while($search_result = mysqli_fetch_assoc($search_data))
            {
                $grp_name = $search_result['grpname'];
                echo "<div class='tab'>
                        <button class='tablinks' onclick='opentabs(event, $grp_name)'><h3>$grp_name<h3></button>
                        </div>";
            }
        ?>
        <button class="split-within-groups">Split within Groups</button>

    </aside>
    
    <!--Main Contain-->
    
    
    <section class="main-content">
        <div class="container">
            <div class="heading">
                
                <span>Welcome</span>
                <div class="expense_container">
                    <button><a class="add_expense">Add Expense</a></button>
                    <button><a class="settle_up">Settle Up</a></button>
                </div>

            </div>

                <h2>Split</h2>
                <hr>
                <form action = "../php2/split.php" method = "post">
                    <input type="text" name="category" placeholder= "Category" required>
                    <input type="number" name="money" placeholder="Enter the amount" required>
                    <button type="submit" name="split">Split</button>
                </form>
        </div>
            
            
        </section>

        <!--Right Contain-->
        
        <aside class="right-container">
            
            <!-- Search Friend -->
            
            
            <h2>Search Friend</h2>
            <hr>
            <form action = "../php2/search.php" method = "post">
                <input type="text" name="name" placeholder="Friend's Name*" required>
                <button type="submit" name="search">Search</button>
            </form>
            
            <!--Invite Friends-->
            
            
            <h2>Invite Friend</h2>
            <hr>
            
            <form action = "../php2/email_invite.php" method = "post" >
                <input type="email" name="email" placeholder="Friend's Email*" required>
                <button type="submit" name="invite">Invite</button>
            </form>
            
            <!--Group Creation-->
            
            
            <h2>Create Group</h2>
            <hr>
            <form action = "../php2/group.php" method = "post">
                <input type="text" name="name" placeholder="Group's Name" required>
                <input type="email" name="email" placeholder="Member's email" required>
                <button type="submit" name="create">Create</button>
            </form>

            <h2>Add Member to Group</h2>
            <hr>
            <form action = "../php2/update_grp.php" method = "post">
                <input type="text" name="name" placeholder="Group's Name" required>
                <input type="email" name="email" placeholder="Member's email" required>
                <button type="submit" name="add_mem">Add</button>
            </form>
            
            
            <!--Add Friends-->
            
            
            <h2>Add Friend</h2>
            <hr>
            <form action = "../php2/addfriends.php" method = "post">
                <input type="email" name="email" placeholder="Friend's Email*" required>
                <button type="submit" name="add">Add</button>
            </form>
        </aside>
        
    </body>   
    <script src = "../js/jquery-3.4.1.js"></script>
    <script src="../js/dashboard.js"></script>
    <script src="./js/nav-mobile.js"></script>
    </html>