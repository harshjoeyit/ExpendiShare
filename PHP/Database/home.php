<?php
session_start();
include('connect.php');

$username = $_SESSION['user_name'];

// if user has logged in and not just typing the address of the home.php
if($username == true )
{
    $query = "SELECT * FROM STUDENT WHERE username = '$username' ";
    $data = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($data);

    echo "Welcome ".$result['name']." <br><br>";
    echo "roll no ".$result['rollno']." <br><br>";
}
else
{   // if the user has not logged in ad tries to access the home.php
    header('location: login.php'); 
}

?>

<img src = '<?php echo $result['picsource']; ?>' alt= '<?php echo $result['name']." profile picture" ; ?>'  
    height = '180' , width = '400' vspace = '20px' hspace = '20px'/>

<a href="logout.php">Log Out</a>