<?php

session_start();
include('connect.php');


$user_email = $_SESSION['email'];

$query = "SELECT user_id FROM users_info WHERE email= '$user_email'";
$data = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($data);

$user_id = $result['user_id'];

if(isset($_POST['split'])){
    
    $search_query = "SELECT friends_id FROM friends_info WHERE user_id = '$user_id'";
    $search_data = mysqli_query($conn, $search_query);
    $search_result = mysqli_fetch_assoc($search_data);
    
    $friends_id = $search_result['friends_id'];
    $friends_id_array = unserialize($friends_id);
    
    $size = count($friends_id_array);
    
    $money = mysqli_real_escape_string($conn, $_POST['money']);
    $category= mysqli_real_escape_string($conn, $_POST['category']);
    
    $split = $money/$size;

    print_r($friends_id_array);
    echo "<br>";
    
    
    
    foreach($friends_id_array as $x => $x_value){
        
        $friend_id = $x_value;
        
        echo "$friend_id";
        echo "<br>";
    }
    
    for($i =0; $i<$size; $i++){
        
        $friend_id = $friends_id_array[$i];
        
        echo "$friends_id";
        echo "<br>";
    }
    echo 


    //INSERTING DATA INTO EXPENSE;


    // $insert_query = "INSERT INTO expense VALUES ('0', '$user_id', '$friend_id', '$money', '$split', '$category', date("y/m/d") )";
    // $execute_query = mysqli_query($conn, $insert_query);

    // if($execute_query){
    //     echo "Data is inserted";
    // }

    // else{
    //     echo "Data is not inserted";
    // }
    
    
}


?>