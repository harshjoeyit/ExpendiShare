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
        if($search_row == 0)
        {
                
            $friend_array = array($friend_id);
            
            $string_array = serialize($friend_array);
            
            $insert_query = "INSERT INTO friends_info VALUES ('$user_id', '$string_array')";
            $insert_data = mysqli_query($conn, $insert_query);
            
            if($insert_data)
            {
                ?>
                <script> window.alert('You are Now Friends') </script>
                <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
                <?php 
            }
            else
            {
                ?>
                <script> window.alert('Freind Not Added') </script>
                <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
                <?php 
            }
        }

        else
        {
            
            // Update the array
            $find_friend_query = "SELECT friends_id FROM friends_info WHERE user_id = '$user_id'";
            $find_friend_data = mysqli_query($conn, $find_friend_query);
            $find_friend_res = mysqli_fetch_assoc($find_friend_data);
            $friend_string = $find_friend_res['friends_id'];
            $friend_array_decode = unserialize($friend_string);
            
            $size = count($friend_array_decode);

            if(in_array($friend_id, $friend_array_decode, TRUE)){
                
                ?>
                <script> window.alert('Freind Already Added') </script>
                <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
                <?php 

            }
            else{
                $updated_friend_array = array_pad($friend_array_decode, $size+1, $friend_id);
                $updated_serialize_array = serialize($updated_friend_array);
                $unserialize_array = unserialize($updated_serialize_array);
                //print_r($unserialize_array);

                $update_query = "UPDATE friends_info SET friends_id = '$updated_serialize_array' WHERE user_id = $user_id";
                $update_data = mysqli_query($conn, $update_query);

                ?>
                <script> window.alert('You Are Now Friends') </script>
                <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
                <?php 
            }
            
            
            
        }

        
        //Adding user as friend in Friend id databse

        $friend_query = "SELECT * FROM friends_info WHERE user_id ='$friend_id' ";
        $friend_data = mysqli_query($conn, $friend_query);
        $friend_row = mysqli_num_rows($friend_data);

        if($friend_row){
            
            $query = "SELECT friends_id FROM friends_info WHERE user_id = '$friend_id'";
            $update_friend = mysqli_query($conn, $query);
            $update_result = mysqli_fetch_assoc($update_friend);

            $member_string = $update_result['friends_id'];

            $member_array = unserialize($member_string);

            if(in_array($user_id, $member_array, TRUE))
            {
                ?>
                <script> window.alert('Friend Already Present') </script>
                <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
                <?php 
            }

            else{
                
                $member_array = array_pad($member_array, count($member_array)+1, $user_id);
                $array_string = serialize($member_array);

                $update_query = "UPDATE friends_info SET friends_id = '$array_string' WHERE user_id = '$friend_id'";
                $updating_data = mysqli_query($conn, $update_query);

                ?>
                <script> window.alert('You Are Now Friends') </script>
                <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
                <?php 

            }
            
            
            //UPDATING THE FRIENDS
        }
        else{
            // INSERTING THE ENTRY

            $array = array($user_id);
            $string = serialize($array);

            $insert_friend_query = "INSERT INTO friends_info VALUES ('$friend_id','$string')";
            $insert_friend_data = mysqli_query($conn, $insert_friend_query);
            

            if($insert_friend_data){

                ?>
                <script> window.alert('You Are Friends Now') </script>
                <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
                <?php 
            }

            else
            {
                ?>
                <script> window.alert('Friend Not Added') </script>
                <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
                <?php 
            }
        }
    }
    else
    {      
        ?>
        <script> window.alert('Your Friend does NOt use ExpendiShare') </script>
        <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
        <?php 
    }
    
}



?>