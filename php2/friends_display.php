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
            background: greenyellow;
            margin: 30px 10px;
            font-size: 45px;
        }

        .date {
            background: green;
            margin-right: 25px;

        }

        .friendinfo {
            background: orange;
        }

        .payment {
            background: blueviolet;
            float: right;
            font-size: 20px;
        }

        .paid {
            background: rgb(204, 61, 61);
            margin-right: 35px;
        }

        .owe {
            background: rgb(32, 139, 122);
            margin-right: 45px;
        }
        img{
            height: 40px;
        }
        .description {
            background: yellow;
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




// looping over all the friends 
foreach($friends_id_array as $x => $x_value)
{
        
    $friend_id = $x_value;                                  // friends id 
   
    // finding freind's info from user_info table
    $find_friend_query = "SELECT * FROM users_info WHERE user_id = '$friend_id' ";
    $find_friend_data = mysqli_query($conn, $find_friend_query);
    $find_friend_result = mysqli_fetch_assoc($find_friend_data);

    $friendname = $find_friend_result['name'];              // friend name

    echo "<br>";
    echo "<h2>".$friendname."</h2>";
    echo "<br>";

    // query for expenses made by the user  
    $expense_query1 = "SELECT * FROM expense WHERE user_id = '$user_id' AND friend_id = '$friend_id' ORDER BY date DESC";
    $expense_data1 = mysqli_query($conn, $expense_query1);
    $total1 = mysqli_num_rows($expense_data1);





    // query for the expenses made by the other user but user is included
    $expense_query2 = "SELECT * FROM expense WHERE friend_id = '$user_id' AND user_id = '$friend_id' ORDER BY date DESC";
    $expense_data2 = mysqli_query($conn, $expense_query2);
    $total2 = mysqli_num_rows($expense_data2);





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

}