
<style>

table{ text-align: center; }
td, th{padding : 10px;
        width: 100px;}
</style>


<?php   

include("connect.php");
error_reporting(0);

// CASE INSENSITIVE - THE RECORDS MAY BE IN LOWERCASE AND QUERY MAY NOT BE 
$query = "SELECT * FROM STUDENT ";
$data = mysqli_query($conn, $query);
$total = mysqli_num_rows($data);

// do not write the line here since it is already in the while loop below 
// this cause us to lose the first entry
//$result = mysqli_fetch_assoc($data);

echo "<br>total rows : $total<br><br>";
echo "<b>".$_GET['msg']."</b><br>";


if($total != 0)
{
    ?>
    
    <table>
        <tr>
            <th>Roll no</th>
            <th>Name</th>
            <th>Class</th>
            <th>image</th>
            <th colspan="2">Operations</th>
        </tr>
    </table>
    
    <?php
    
    while( $result = mysqli_fetch_assoc($data) )
    {
        echo "<table>
                <tr>
                    <td>".$result['rollno']."</td>
                    <td>".$result['name']."</td>
                    <td>".$result['class']."</td>
                    <td><a href = '".$result['picsource']."'><img src='".$result['picsource']."' height='50px' width='90px' /></a></td>
                    <td> <a href = 'update.php?rn=$result[rollno]&sn=$result[name]&cl=$result[class]'>Edit</a> </td>
                    <td> <a href = 'delete.php?rn=$result[rollno]' onclick = 'return checkdelete()'>Delete</a> </td>
                </tr>
            </table>";
    }
}
else
{
    echo "data not find<br>";
}


?>


<script>
function checkdelete()
{
    return confirm('Are you sure you want to delete the data ? ');
    // important for the warning
}
</script>