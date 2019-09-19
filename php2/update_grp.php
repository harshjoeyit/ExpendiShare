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


    if(isset($_POST['add_mem']))
    {
        
        $grp_name = mysqli_real_escape_string($conn, $_POST['name']);
        $member_email = mysqli_real_escape_string($conn, $_POST['email']);

        $search_grp = "SELECT grpname FROM grps_info WHERE user_id = '$user_id'";
        $search_grp_data = mysqli_query($conn, $search_grp);
        // $search_grp_array = mysqli_fetch_array($search_grp_data);
        // print_r($search_grp_array);
        // $search_grp_array = mysqli_fetch_array($search_grp_data);
        // print_r($search_grp_array);
        $rows = mysqli_num_rows($search_grp_data);
        $search_grp_array = array();

        echo "$rows";
        while($rows--){
            $grps = mysqli_fetch_assoc($search_grp_data);
            $search_grp_array[] = $grps['grpname'];
            //print_r($search_grp_array);
        }
        print "<br>";
        print_r($search_grp_array);

        // $search_grp_array = array();
        // $i =0;
        // echo "Hello";

        // while($row = mysql_fetch_array($search_grp_data)) {
        //     // $search_grp_array[$i++] = $row['grpname'];
        //     print_r($row);
        //     echo "Not Hello";
        // }   

        // print_r($search_grp_array);
        // echo "HEllo;";

        $grp_count = 0;

        foreach($search_grp_array as $y => $y_value)
        {

            if($y_value == $grp_name){
                $grp_count++;
            }
        }

        if($grp_count)
        {

            $search_query = "SELECT * FROM users_info WHERE email = '$member_email'";
            $search_data = mysqli_query($conn, $search_query);
            $search_result = mysqli_fetch_assoc($search_data);
            
            if($search_result)
            {
                
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
    
                    if($update_data)
                    {
                        ?>
                        <script> window.alert('Group Updated') </script>
                        <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
                        <?php 
                    }
                    else
                    {
                        ?>
                        <script> window.alert('Could not Update the Group') </script>
                        <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
                        <?php 
                    }
                }
            
            }

            else
            {
                ?>
                <script> window.alert('Member Not Found') </script>
                <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
                <?php 
            }   
        }

        else
        {
            ?>
            <script> window.alert('Group Not Found') </script>
            <meta http-equiv="refresh" content="0; URL='dashboard.php'" /> 
            <?php 
        }

    }


?>