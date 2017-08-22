<?php
session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: ../index.php", true, 301);
    exit;
}
require_once ("../class/Database.php");
require_once ("../class/User.php");
$database = new Database();
$db = $database->DbConnection();
$user = new User($db);
$user->setUsername($_SESSION['username']);

if (isset($_POST['password']) && !empty($_POST['password'])) {
    $user->setPassword(sha1($_POST['password']));
    $sql = "UPDATE user SET password=:password WHERE username=:username";
    $stmt = $user->updateUser($sql);
    if ($stmt) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "no";
}
?>