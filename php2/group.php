<?php
    session_start();
    include("connect.php");


    $user_email= $_SESSION['email'];
    $find_query= "SELECT user_id FROM users_info WHERE email= '$user_email'";
    $find = mysqli_query($conn, $find_query);
    $result = mysqli_fetch_assoc($find);
    //print_r($result);
    $user_id = $result['user_id'];

    if(isset($_POST['create']))
    {
        $grpname= mysqli_real_escape_string($conn,$_POST['name']);

        $query = "SELECT grpname FROM grps_info WHERE user_id = '$user_id'";
        $query_data = mysqli_query($conn, $query);
        $query_result = mysqli_num_rows($query_data);

        if(!$query_result){

            if($grpname != "")
        {
            $member_email = mysqli_real_escape_string($conn, $_POST['email']);


            //Searching member in users_info table

            $search_query = "SELECT user_id FROM users_info WHERE email= '$member_email'";
            $search_data = mysqli_query($conn, $search_query);
            $search_result = mysqli_fetch_assoc($search_data);

            if($search_result==0){
                ?> <script>alert("user not found");</script><!--Meta Redirect --><?php
            }
            
            else{
                $member_id = $search_result['user_id'];
                $members_array = array($member_id);

                //Serializing the array

                $member_serialize = serialize($members_array);
                
                $insert_query= "INSERT INTO grps_info VALUES ('$user_id', '0','$grpname', '$member_serialize')";
                $data = mysqli_query($conn, $insert_query);
                if($data)
                {
                    echo "Created";
                }
                else{
                    echo "not Created";
                }

            }
            // Adding Group in the member's database

            $array = array($user_id);
            $string = serialize($array);
            $insert_query = "INSERT INTO grps_info VALUES('$member_id', '0', '$grpname', '$string')";
            $insert_data = mysqli_query($conn, $insert_query);
        }

        }
        else{

            echo "Groups already exist";
        }

        
    }

?>