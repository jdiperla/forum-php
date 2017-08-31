<?php
session_start();
require_once('../class/Database.php');
require_once('../class/User.php');

$database = new Database();
$db = $database->DbConnection();
$user= new User($db);
$username=htmlspecialchars($_POST['username']);
$password=hash('sha256', htmlspecialchars($_POST['password']));
$user->setUsername($username);
$sql="SELECT user.username ,user.password ,GROUP_CONCAT(user_roles.role SEPARATOR ' ') as role FROM user,user_roles WHERE user.username=user_roles.username and user.username=:username GROUP BY user.username";
$stmt = $user->selectUser($sql);
if($stmt) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($row)) {
       if($row['username']==$username && $row['password']==$password){
           $role=explode(" ",$row['role']);
           if(in_array("ROLE_ADMIN" ,$role)){
               $_SESSION['username']=$username;
               $_SESSION['role']="admin";
               echo "admin";
           }
           else{
               $_SESSION['username']=$username;
               $_SESSION['role']="user";
               echo "user";
           }
       }
       else{
           echo "false";
       }
    }
    else{
        echo "false";
    }
}
else {
    echo "false";
}
