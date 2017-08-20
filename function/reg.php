<?php
require_once ("../class/Database.php");
require_once ("../class/User.php");
$database = new Database();
$db = $database->DbConnection();
$user= new User($db);
$user->setUsername($_POST['username']);
$user->setPassword($_POST['password']);
$sql="INSERT INTO user (username, password) VALUES (:username, :password);";
$stmt = $user->insertUser($sql);

$user->setRole(array($_POST['roles']));
$sql="INSERT INTO user_roles (username, role) VALUES (:username, :role);";
$stmt = $user->insertRole($sql);

if($stmt){
    echo "success";
}
else{
    echo "no";
}
?>