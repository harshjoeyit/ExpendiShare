<?php

session_start();
include('connect.php');
error_reporting(0);

$user_email = $_SESSION['email'];
$find_query = "SELECT user_id from users_info WHERE email = '$user_email'";
$data = mysqli_query($conn, $find_query);
$result = mysqli_fetch_assoc($data);

$user_id = $result['user_id'];

$search_query = "SELECT * FROM friends_info WHERE user_id ='$user_id' ";
$search_data = mysqli_query($conn, $search_query);
$search_row = mysqli_num_rows($search_data);

if(isset($_POST['add']))
{
    $curr_email = mysqli_real_escape_string($conn, $_POST['email']);
    $find_query2 = "SELECT * FROM users_info WHERE email = '$curr_email' " ;
    $data2 = mysqli_query($conn, $find_query2);
    $total = mysqli_num_rows($data2);
    $res = mysqli_fetch_assoc($data2);
    $friend_id = $res['user_id'];
    
    if($total == 1)
    {
        if($search_row == 0){
            
            
            $friend_array = array($friend_id);
            
            $string_array = serialize($friend_array);
            
            $insert_query = "INSERT INTO friends_info VALUES ('$user_id', '$string_array')";
            $insert_data = mysqli_query($conn, $insert_query);
            
            if($insert_data)
            {
                echo "datas inserted ";
            }
            else
            echo "not inserted ";
        }
        else{
            
            // Update the array
            $find_friend_query = "SELECT friends_id FROM friends_info WHERE user_id = '$user_id'";
            $find_friend_data = mysqli_query($conn, $find_friend_query);
            $find_friend_res = mysqli_fetch_assoc($find_friend_data);
            $friend_string = $find_friend_res['friends_id'];
            $friend_array_decode = unserialize($friend_string);
            
            $size = count($friend_array_decode);
            
            $updated_friend_array = array_pad($friend_array_decode, $size+1, $friend_id);
            $updated_serialize_array = serialize($updated_friend_array);
            $unserialize_array = unserialize($updated_serialize_array);
            print_r($unserialize_array);

            $update_query = "UPDATE friends_info SET friends_id = '$updated_serialize_array'";
            $update_data = mysqli_query($conn, $update_query);
            
        }
    }
    
    
}

?>