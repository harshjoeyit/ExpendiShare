<?php
    include('connect.php');
    session_start();
    error_reporting(0);

    $user_email = $_SESSION['email'];

    $query = "SELECT * FROM users_info WHERE email = '$user_email'";
    $data = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($data);

    $user_id = $result['user_id'];

    //Searching User's Group

    $grp_query = "SELECT * FROM grps_info WHERE user_id='$user_id'";
    $grp_query_data = mysqli_query($conn, $grp_query);
    $grp_result = mysqli_fetch_assoc($grp_query_data);

    $grp_members = unserialize($grp_result['members_id']);


    if(isset($_POST['add_mem'])){
        
        $grp_name = mysqli_real_escape_string($conn, $_POST['name']);
        $member_email = mysqli_real_escape_string($conn, $_POST['email']);

        $search_grp = "SELECT grpname FROM grps_info WHERE user_id = '$user_id' AND grpname = '$grp_name'";
        $search_grp_data = mysqli_query($conn, $search_grp);
        $rows = mysqli_num_rows($search_grp_data);

        $search_grp_array = array();

        while($rows--){
            $grps = mysqli_fetch_assoc($search_grp_data);
            $search_grp_array[] = $grps['grpname'];
        }

        print_r($search_grp_array);

        if(in_array($grp_name, $search_grp_array, TRUE)){

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
    
                    $grp_members1 = array_pad($grp_members, count($grp_members)+1, $member_id);
    
                    //Serializing the group member's array
    
                    $grp = serialize($grp_members1);
    
                    //Updating the grps_info database
    
                    $update_query = "UPDATE grps_info SET members_id = '$grp' WHERE user_id = '$user_id'";
                    $update_data = mysqli_query($conn, $update_query);
    
                    if($update_data){
                        echo "Updated";
                    }
                    else{
                        echo "Not Updated";
                    }
                    // adding grp to member
                    $grp_members2 = array_pad($grp_members, count($grp_members)+1,$user_id);
                    $grps = serialize($grp_members2);

                    $insert_query = "INSERT INTO grps_info VALUES ('$member_id', '0', '$grp_name', '$grps')";
                    $insert_data = mysqli_query($conn, $insert_query);
                }
                
    
            }
            else{
                echo "Not Found";
            }
        }

        else{
            echo "Group not Found";
        }

    }
    
?>