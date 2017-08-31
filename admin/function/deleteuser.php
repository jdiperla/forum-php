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
$user->setUsername(htmlspecialchars($_POST['username']));
$sql="DELETE FROM user WHERE username=:username ";
$stmt = $user->deleteUserOrRole($sql);
if($stmt)
    echo "success";
else
    echo "false";

?>
