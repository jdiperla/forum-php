<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username']) && $_SESSION['role']!="admin"){
   header("Location: ../index.php", true, 301);
    exit;
}

require_once ("../../class/Database.php");
require_once ("../../class/User.php");

$database = new Database();
$db = $database->DbConnection();
$user= new User($db);
$user->setUsername($_POST['username']);
$check=false;

if(isset($_POST['password']) && !empty($_POST['password'])){
    $user->setPassword($_POST['password']);
    $sql="UPDATE user SET password=:password WHERE username=:username";
    $stmt = $user->updateUser($sql);
    if($stmt)
        $check=true;
}

if(isset($_POST['role']) && !empty($_POST['role'])){
    $role=array();
    foreach($_POST['role'] as $check) {
        array_push($role,$check);
    }
    $user->setRole($role);
    $sql="DELETE FROM user_roles WHERE username=:username";
    $stmt = $user->deleteUserOrRole($sql);
    if($stmt){
        $sql="INSERT INTO user_roles (username, role) VALUES (:username, :role)";
        $stmt_1 = $user->insertRole($sql);
        if($stmt_1){
            $check=true;
        }
    }
}
if($check)
    echo "success";
else
    echo "false";
?>