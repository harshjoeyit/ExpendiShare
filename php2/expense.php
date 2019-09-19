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
    $user_id = $result['user_id'];  
}
else
{ 
    header('location: ../html/login.html'); 
}

?>





<style>
       @import url('https://fonts.googleapis.com/css?family=Montserrat:500&display=swap');
 
        .expense {
            border-radius: 10px;
            border-top: 3px solid white; 
            border-bottom: 3px solid rgb(119, 109, 109); 
            background-color: #E3E4DB;
            width: 880px;
            height: 100px;
            padding: 1px 15px 15px 15px;
            color: black;
            font-family: "Montserrat", sans-serif;
        }

        .date,
        .friendinfo,
        .payment,
        .description,
        .amount1,
        .amount2 {
            display: inline;
            /* font-size: 30px; */
        }

        .info {
            margin: 30px 10px;
            font-size: 45px;
        }

        .date {
            margin-right: 25px;
            border-right: 1px solid;
        }

        .payment {
            float: right;
            font-size: 20px;
        }

        .paid {
            margin-right: 35px;
            font-size: 20px;
        }

        .owe {
            margin-right: 45px;
            font-size: 20px;
        }
        
        .description {
            width: 300px;
        }

        .amount1{
            margin-right: 50px;
             float: right;   
        }
        .amount2{
            margin-right: 40px;
            float:right;
        }

    </style>






<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses | ExpendiShare</title>
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
            $search_result = mysqli_fetch_assoc($search_data);
            $friends_id = $search_result['friends_id'];
            $friends_id_array = unserialize($friends_id);
            
            foreach($friends_id_array as $x => $x_value){
                $find_name_query = "SELECT * FROM users_info WHERE user_id = '$x_value'";
                $find_name_data = mysqli_query($conn, $find_name_query);
                $find_name_result = mysqli_fetch_assoc($find_name_data);

                $friend_name = $find_name_result['name'];
                

                //Tab Layout for Friends Display

                echo "<div class='tab'>
                        <button><a  style='color: black; font-size: 22px; padding-left: 10px' href = 'expense.php?group_id=0&friend_id=$x_value' >".$friend_name."</a></button>
                        </div>";
            }
        ?>
        <button class="split-with-friends">Split with Friends</button>
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
        
                <?php 
                    // pass group id = 0 when only friends are to displayed 
                    // and vice versa 

                    $group_id = $_GET['group_id'];
                    $friend_id = $_GET['friend_id'];


                    if($friend_id != 0)
                    {


                        // finding freind's info from user_info table
                        $find_friend_query = "SELECT * FROM users_info WHERE user_id = '$friend_id' ";
                        $find_friend_data = mysqli_query($conn, $find_friend_query);
                        $find_friend_result = mysqli_fetch_assoc($find_friend_data);

                        $friendname = $find_friend_result['name'];  

                        echo "<hr><h2 style='text-align: center; margin: 20px auto;'>Your Expenses with ".$friendname."</h2><hr>";    


                        // query for expenses made by the user  
                        $expense_query1 = "SELECT * FROM expense WHERE user_id = '$user_id' AND friend_id = '$friend_id' ORDER BY date DESC";
                        $expense_data1 = mysqli_query($conn, $expense_query1);
                        $total1 = mysqli_num_rows($expense_data1);




                        // query for the expenses made by the friend but user is included
                        $expense_query2 = "SELECT * FROM expense WHERE friend_id = '$user_id' AND user_id = '$friend_id' ORDER BY date DESC";
                        $expense_data2 = mysqli_query($conn, $expense_query2);
                        $total2 = mysqli_num_rows($expense_data2);



                        echo "<br><h2>".$friendname." owes you : </h2><br>";    
                        // displaying the transactions made by the user
                        if($total1 != 0)
                        {


                            while( $result = mysqli_fetch_assoc($expense_data1) )
                            {
                                $date = $result['date'];
                                $day = $date[8].$date[9];
                                $month = $date[5].$date[6];
                                $dm = $day."/".$month;
                            
                                echo "<div class='expense'>
                                        <div class='payment'>
                                            <span class='paid'>You Paid</span>
                                            <span class='owe'> You lent</span>
                                        </div>
                                        <div class='info'>
                                            <div class='date'>
                                                <span class='display_date'>".$dm."</span>
                                            </div>
                                        <div class='friendinfo'>
                                            <div class='description'>".$result['category']."</div>
                                            <div class='amount1'>".$result['owed']."</div>
                                            <div class='amount2'>".$result['paid']."</div>
                                        </div>
                                        </div>
                                    </div>";
                            }
                        }

                        else
                        {
                            echo "<br><h2>".$friendname." doesn't owe you anything</h2><br>";
                        }




                        echo "<br><h2>you owe to ".$friendname." : </h2><br>"; 




                        if($total2 != 0)
                        {
                        
                            while( $result = mysqli_fetch_assoc($expense_data2) )
                            {

                                $date = $result['date'];
                                $day = $date[8].$date[9];
                                $month = $date[5].$date[6];
                                $dm = $day."/".$month;

                                echo "<div class='expense'>
                                        <div class='payment'>
                                            <span class='paid'>Friend Paid</span>
                                            <span class='owe'> He lent</span>
                                        </div>
                                        <div class='info'>
                                            <div class='date'>
                                                <span class='display_date'>".$dm."</span>
                                            </div>
                                        <div class='friendinfo'>
                                            <div class='description'>".$result['category']."</div>
                                            <div class='amount1'>".$result['owed']."</div>
                                            <div class='amount2'>".$result['paid']."</div>
                                        </div>
                                        </div>
                                    </div>";
                            }
                        }

                        else
                        {
                            echo "<br><h2>You dont owe anything to ".$friendname."</h2><br>";
                        }



                    }
                 

                ?>
        </div>
    </section>



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
        
        
        
        
        <script src = "../js/jquery-3.4.1.js"></script>
        <script src="../js/dashboard.js"></script>
        <script src="./js/nav-mobile.js"></script>
        
    </body>   
    </html>