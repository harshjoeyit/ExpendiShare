<?php
    include('connect.php');
    session_start();
    error_reporting(0);

    $user_email = $_SESSION['email'];

    $query = "SELECT * FROM users_info WHERE email = '$user_email'";
    $data = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($data);

    $user_id = $result['user_id'];

    //Search Users Group

    $grp_query = "SELECT * FROM grps_info WHERE user_id='$user_id'";
    $grp_query_data = mysqli_query($conn, $grp_query);
    $grp_result = mysqli_fetch_assoc($grp_query_data);

    $grp_members = unserialize($grp_result['members_id']);

    //print_r($grp_members);

    // print_r($grp_result);


    if(isset($_POST['add_mem'])){
        
        $grp_name = mysqli_real_escape_string($conn, $_POST['name']);
        $member_email = mysqli_real_escape_string($conn, $_POST['email']);

        $search_query = "SELECT * FROM users_info WHERE email = '$member_email'";
        $search_data = mysqli_query($conn, $search_query);
        $search_result = mysqli_fetch_assoc($search_data);
        
        if($search_result){
            
            $member_id = $search_result['user_id'];


            $count = 0;

            foreach($grp_members as $x => $x_value){

                if($x_value == $member_id){
                    $count++;
                }
            }
            
            if(!$count){

                //Updating Group Members

                $grp_members = array_pad($grp_members, count($grp_members)+1, $member_id);

                //Serializing the group member's array

                $grp = serialize($grp_members);

                //Updating the grps_info database

                $update_query = "UPDATE grps_info SET members_id = '$grp'";
                $update_data = mysqli_query($conn, $update_query);

                if($update_data){
                    echo "Updated";
                }
                else{
                    echo "Not Updated";
                }
            }
            

        }
        else{
            echo "Not Found";
        }
    }


?>