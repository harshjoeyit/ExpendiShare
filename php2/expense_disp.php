<style>

body
{
    color: white;
} 

table
{ 
    text-align: center; 
}
td, th
{
    padding : 10px;
    width: 100px;
}

</style>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/dash.css">
</head>

<body>
   
</body>   
</html>



<!-- ........................................................ -->





<?php

session_start();
include('connect.php');
error_reporting(0);

$user_email = $_SESSION['email'];

// from user info table
$user_query = "SELECT * FROM users_info WHERE email = '$user_email' ";
$user_data = mysqli_query($conn, $user_query);
$user_result = mysqli_fetch_assoc($user_data);
$username = $user_result['name'];
$user_id = $user_result['user_id'];


// query for expenses made by the user 
 
$expense_query = "SELECT * FROM expense WHERE user_id = '$user_id'";
$expense_data = mysqli_query($conn, $expense_query);
$total = mysqli_num_rows($expense_data);


echo "<br>user : $username<br>";
echo "<br>user id : $user_id<br>";
echo "<br>total rows : $total<br>";


// query for the expenses made by the other user but user is included
$expense_query2 = "SELECT * FROM expense WHERE friend_id = '$user_id'";
$expense_data2 = mysqli_query($conn, $expense_query2);
$total2 = mysqli_num_rows($expense_data2);

echo "<br>total rows : $total2<br><br>";


//expenss by the user 

if($total != 0)
{
    ?>
    
    <table>
        <h2>>expenses added by you </h2>
        <tr>
            <th>expense id </th>
            <th>paid by</th>
            <th>lent to</th>
            <th>paid amount</th>
            <th>owed</th>
            <th>category</th>
        </tr>
    </table>
    
    <?php
    
    while( $result = mysqli_fetch_assoc($expense_data) )
    {
       // now the other user is friend  
        $friend_id = $result['friend_id'];

        // finding freind's info from user_info table
        $find_friend_query = "SELECT * FROM users_info WHERE user_id = '$friend_id' ";
        $friend_data = mysqli_query($conn, $find_friend_query);
        $friend_result = mysqli_fetch_assoc($friend_data);

        $friendname = $friend_result['name'];

            echo "<table>
            <tr>
                <td>".$result['expense_id']."</td>
                <td>".$username."</td>
                <td>".$friendname."</td>
                <td>".$result['paid']."</td>
                <td>".$result['owed']."</td>
                <td>".$result['category']."</td>
                </tr>
            </table>";
    }
}
else
{
    echo "data not found<br>";
}





// expenses by the other users

if($total2 != 0)
{
    ?>
    
    <table>
        <h2>>expenses added by you </h2>
        <tr>
            <th>expense id </th>
            <th>paid by</th>
            <th>lent to</th>
            <th>paid amount</th>
            <th>owed</th>
            <th>category</th>
        </tr>
    </table>
    
    <?php
    
    while( $result = mysqli_fetch_assoc($expense_data2) )
    {
       // friends id from the expense table 
        $friend_id = $result['user_id'];

        // finding freind's info from user_info table
        $find_friend_query = "SELECT * FROM users_info WHERE user_id = '$friend_id' ";
        $friend_data = mysqli_query($conn, $find_friend_query);
        $friend_result = mysqli_fetch_assoc($friend_data);

        $friendname = $friend_result['name'];

            echo "<table>
            <tr>
                <td>".$result['expense_id']."</td>
                <td>".$friendname."</td>
                <td>".$username."</td>
                <td>".$result['paid']."</td>
                <td>".$result['owed']."</td>
                <td>".$result['category']."</td>
                </tr>
            </table>";
    }
}
else
{
    echo "data not found<br>";
}

// expenses that were made by the other users for the user 


?>

<script>
function checkdelete()
{
    return confirm('Are you sure you want to delete the data ? ');
}
</script>







<!-- adding date and time to the table  -->

<?php

// date time 
$raw = "Sun Mar 23 06:39:16 +0000 2008";
$xplod = explode(' ', $raw);
print_r($xplod);

$string = "$xplod[5]-$xplod[1]-$xplod[2] $xplod[3]";
echo "<br />".$string;

$date = date("Y-m-d H:i:s", strtotime($string));
echo "<br>".$date;

$q = "UPDATE expense SET date = '$date' WHERE user_id = '$user_id' ";
if(mysqli_query($conn, $q))
{
    echo "<br>date added ";
}
else
{
    echo "<br>date not added ";
}


$q2 = "SELECT date FROM expense WHERE user_id = '$user_id' ";
$d2 = mysqli_query($conn, $q2);
$ur = mysqli_fetch_assoc($d2);
$d = $ur['date'];


$day = $d[8].$d[9];
$month = $d[5].$d[6];
echo "<br> day: $day";
echo "<br> month: $month ";


?>