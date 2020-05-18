<?php
    include_once('class.misc.php');
    $misc = new misc();
    $connect = mysqli_connect("localhost", "root", "", "ExpendiShare");
    // if($connect) {
    //     echo "connection estabilished";
    // }
    
    $output = '';
    // ..............................................................................................fetch freinds usernames
    if(isset($_POST["query"])) {
    
        $search = mysqli_real_escape_string($connect, $_POST["query"]);
        $query = "
        SELECT * FROM users
        WHERE username LIKE '%".$search."%'
        ";

        $result = mysqli_query($connect, $query);
        
        if(mysqli_num_rows($result) > 0) {
            $output .= '<table>
                            <tr>
                                <th> Username </th>
                            <tr>';
        
            while($row = mysqli_fetch_assoc($result)) {
                $output .= '
	        		<tr>
	        			<td style="color: purple">'.$row["username"].'</td>
	        	    ';
            }

            echo $output; 
        } else {
            echo '<p style="color: blue"> No users matching your Friends name. <br> 
                    Dont worry you can still add him/her <p>'; 
        }
    
    } else if(isset($_POST["display"])) {
        
        $username = $_POST["display"];
        $result = $misc->displayFriends($username);
        if(count($result) == 0) {
            echo "Add some friends";
        }
        foreach($result as &$name) {
            echo "<li class='allfriends' style='margin:2px;'>$name</li>";
        }

    // testing for sending json encoded data
    } if(isset($_POST['action'])) {
       
        $result = $misc->displayFriends('harshit');
        if(count($result) == 0) {
            echo "Add some friends";
        }
        foreach($result as &$name) {
            echo "<li class='allfriends' style='margin:2px;'>$name</li>";
        }
    }
?>