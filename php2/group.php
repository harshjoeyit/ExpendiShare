<?php
    session_start();
    include("connect.php");


    $user_email= $_SESSION['email'];
    $find_query= "SELECT user_id FROM users_info WHERE email= '$user_email'";
    $find = mysqli_query($conn, $find_query);
    $result = mysqli_fetch_assoc($find);
    echo "$result";
    if($_POST['create'])
    {
        $grpname= mysqli_real_escape_string($conn,$_POST['name']);

        if($grpname != "")
        {
            $insert_query= "INSERT INTO grps_info VALUES ('1', '0','$grpname', 'Creted')";
            $data = mysqli_query($conn, $insert_query);
            if($data)
            {
                echo "Created";
            }
            else{
                echo "not";
                echo $grpname;
            }
        }
    }

?>