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

// echo $user_email."<br>".$user_id;
// echo "<br>".$user_name;





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

    // echo "$friend_id"."$friendname";
    // echo "<br>";

    // query for expenses made by the user  
    $expense_query1 = "SELECT * FROM expense WHERE user_id = '$user_id' AND friend_id = '$friend_id' ";
    $expense_data1 = mysqli_query($conn, $expense_query1);
    $total1 = mysqli_num_rows($expense_data1);





    // query for the expenses made by the other user but user is included
    $expense_query2 = "SELECT * FROM expense WHERE friend_id = '$user_id' AND user_id = 'friend_id' ";
    $expense_data2 = mysqli_query($conn, $expense_query2);
    $total2 = mysqli_num_rows($expense_data2);





    // displaying the transactions made by the user

    if($total1 != 0)
    {

        ?>
    
        <table>
            <h2>>expenses added by you </h2>
            <tr>
                <th>expense id </th>
                <th>paid amount</th>
                <th>owed</th>
                <th>category</th>
            </tr>
        </table>
    
        <?php
    
        while( $result = mysqli_fetch_assoc($expense_data1) )
        {

            echo "<table>
            <tr>
                <td>".$result['expense_id']."</td>
                <td>".$result['paid']."</td>
                <td>".$result['owed']."</td>
                <td>".$result['category']."</td>
                </tr>
            </table>";
        }
    }

    else
    {
        echo "data not found<br>";
    }

    if($total2 != 0)
    {

        ?>
    
        <table>
            <h2>>expenses added by you </h2>
            <tr>
                <th>expense id </th>
                <th>paid amount</th>
                <th>owed</th>
                <th>category</th>
            </tr>
        </table>
    
        <?php
    
        while( $result = mysqli_fetch_assoc($expense_data2) )
        {

            echo "<table>
            <tr>
                <td>".$result['expense_id']."</td>
                <td>".$result['paid']."</td>
                <td>".$result['owed']."</td>
                <td>".$result['category']."</td>
                </tr>
            </table>";
        }
    }

    else
    {
        echo "data not found<br>";
    }

}