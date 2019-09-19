<style>
        h2{
            background: black;
            color: white;
        }
        .expense {
            border-radius: 10px;
            border-top: 3px solid rgb(228, 192, 199); 
            border-bottom: 3px solid rgb(221, 110, 131); 
            background: pink;
            width: 800px;
            height: 100px;
            padding: 1px 15px 15px 15px;
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
        }

        .owe {
            margin-right: 45px;
        }
        img{
            height: 40px;
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




        #_3
        {
            background: red;
        }
        #_4
        {
            background: blue;
        }




* {box-sizing: border-box}

/* Style the tab */
.tab {
  float: left;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 30%;
}

/* Style the buttons that are used to open the tab content */

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  float: left;
  padding: 0px 12px;
  border: 1px solid #ccc;
  width: 70%;
  border-left: none;
  height: 300px;
}


    </style>

<script>
    
    function openCity(evt, cityName) 
    {
  
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the link that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";

}
    </script>




<?php

session_start();
include('connect.php');
error_reporting(0);
$user_email = $_SESSION['email'];





// query for finding user id
$user_query = "SELECT user_id FROM users_info WHERE email= '$user_email'";
$user_data = mysqli_query($conn, $user_query);
$user_result = mysqli_fetch_assoc($user_data);

$user_name = $user_result['name'];
$user_id = $user_result['user_id'];             // user_id

echo $user_email."<br>".$user_id;
echo "<br>".$user_name;





// query for finding the friends of the user 
$friends_query = "SELECT friends_id FROM friends_info WHERE user_id = '$user_id'";
$friends_data = mysqli_query($conn, $friends_query);
$friends_result = mysqli_fetch_assoc($friends_data);

$friends_id = $friends_result['friends_id'];                // serialized array
$friends_id_array = unserialize($friends_id);               // userialized array
$size = count($friends_id_array);                           // number of friends 



echo " <div class='tab'>";

// displaying all the friends for the tab 
foreach($friends_id_array as $x => $x_value)
{
        
    $friend_id = $x_value;     // friends id 
    $id = (string)$friend_id;
    $id = "_".$id;
    
    $find_friend_query = "SELECT * FROM users_info WHERE user_id = '$friend_id' ";
    $find_friend_data = mysqli_query($conn, $find_friend_query);
    $find_friend_result = mysqli_fetch_assoc($find_friend_data);

    $friendname = $find_friend_result['name'];              

    echo "<button class = 'tablinks' onclick = 'openCity(event, $id )'>$id.$friendname</button>";

}

echo "</div>";






// looping over all the friends 
foreach($friends_id_array as $x => $x_value)
{
        
    $friend_id = $x_value;     // friends id 
    $id = (string)$friend_id;
    $id = "_".$id;                          
   
    
    
    
    // finding freind's info from user_info table
    $find_friend_query = "SELECT * FROM users_info WHERE user_id = '$friend_id' ";
    $find_friend_data = mysqli_query($conn, $find_friend_query);
    $find_friend_result = mysqli_fetch_assoc($find_friend_data);

    $friendname = $find_friend_result['name'];              // friend name

    

    
    // query for expenses made by the user  
    $expense_query1 = "SELECT * FROM expense WHERE user_id = '$user_id' AND friend_id = '$friend_id' ORDER BY date DESC";
    $expense_data1 = mysqli_query($conn, $expense_query1);
    $total1 = mysqli_num_rows($expense_data1);





    // query for the expenses made by the other user but user is included
    $expense_query2 = "SELECT * FROM expense WHERE friend_id = '$user_id' AND user_id = '$friend_id' ORDER BY date DESC";
    $expense_data2 = mysqli_query($conn, $expense_query2);
    $total2 = mysqli_num_rows($expense_data2);



    // unique id for each div 
    // id decides which element is show and which is hidden

    echo "<div id = '$id' class = 'tabcontent' >";

    echo "<h2>id: $id ".$friendname."</h2>";
    echo "<br>";

    // displaying the transactions made by the user
    if($total1 != 0)
    {
        
        
        while( $result = mysqli_fetch_assoc($expense_data1) )
        {

            echo "<div class='expense'>
                    <div class='payment'>
                        <span class='paid'>You Paid</span>
                        <span class='owe'> You lent</span>
                    </div>
                    <div class='info'>
                        <div class='date'>
                            <span class='display_date'>Date</span>
                        </div>
                    <div class='friendinfo'>
                        <img src='' alt='image'>
                        <div class='description'>".$result['category']."</div>
                        <div class='amount1'>".$result['paid']."</div>
                        <div class='amount2'>".$result['owed']."</div>
                    </div>
                    </div>
                </div>";
        }
    }

    else
    {
        echo "data not found<br>";
    }

    if($total2 != 0)
    {
    
        while( $result = mysqli_fetch_assoc($expense_data2) )
        {

            echo "<div class='expense'>
                    <div class='payment'>
                        <span class='paid'>You Paid</span>
                        <span class='owe'> You lent</span>
                    </div>
                    <div class='info'>
                        <div class='date'>
                            <span class='display_date'>Date</span>
                        </div>
                    <div class='friendinfo'>
                        <img src='' alt='image'>
                        <div class='description'>".$result['category']."</div>
                        <div class='amount1'>".$result['paid']."</div>
                        <div class='amount2'>".$result['owed']."</div>
                    </div>
                    </div>
                </div>";
        }
    }

    else
    {
        echo "data not found<br>";
    }

    echo "</div>";
}