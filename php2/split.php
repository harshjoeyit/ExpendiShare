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
    
    
    $today_date = date('Y-m-d H:i:s');
    
    foreach($friends_id_array as $x => $x_value){
        
        $friend_id = $x_value;
        //Dispaly friends

        $find_query = "SELECT name FROM users_info WHERE user_id = '$friend_id' ORDER BY 'name'";
        $find_query_data = mysqli_query($conn, $find_query);
        $find_result = mysqli_fetch_assoc($find_query_data);

        $friend_name= $find_result['name'];

        echo $friend_name;
        echo "<br>";
        
        
    }
    
    // if($execute_query){
    //     echo "Data is inserted";
    // }
    
    // else{
    //     echo "Data is not inserted";
    // }
    
}
//INSERTING DATA INTO EXPENSE;
// $insert_query = "INSERT INTO expense VALUES ('0', '$user_id', '$friend_id', '$money', '$split', '$category', '$today_date' )";
// $execute_query = mysqli_query($conn, $insert_query);

// echo "$friend_id";
// echo "<br>";


?>