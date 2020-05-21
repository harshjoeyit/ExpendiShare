<?php
include_once('class.misc.php');
include_once('class.sql.php');
$misc = new misc();
$sql = new sql();
// $username = 'aman';
// $lastId = $sql->getDistinctDatas('id', 'users', 'username', $username);
// print_r($lastId);
// echo $lastId[0];
// $password = '123456';
// $password = md5($password);
// $activated = 0;
// $token = sha1($lastId[0]);
// $todays_date = date('Y-m-d');
// echo "<br>";
// echo $password;
// echo "<br>";

// echo $token;
// echo "<br>";
// echo $todays_date;
// echo "<br>";
// // INSERT INTO `login` (username,password, activated, token, created_on) values('aman','e10adc3949ba59abbe56e057f20f883e', 0, '356a192b7913b04c54574d18c28d46e6395428ab','2020-05-19')
// $sql->query = "INSERT INTO `login` (username,password, activated, token, created_on) values('$username','$password', $activated, '$token','$todays_date')";
// $sql->process();
// require 'sendmail.php';
// $data = sendmail('amantibrewal03@gmail.com', 'Hello');
// print_r($data);

$result = $sql->searchData('users', 'username', 'username', 'a');
print_r($result);
$res = $misc->displayFriends('aman');
print_r($res);

?>