<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SESSION['role']!="admin"){
    header("Location: ../index.php", true, 301);
    exit;
}
require_once('../class/Database.php');
require_once('../class/Thread.php');
require_once('../class/Reply.php');
$database = new Database();
$db = $database->DbConnection();
if($_POST['type']=="thread"){
    $thread= new Thread($db);
    $thread->setId(htmlspecialchars($_POST['id']));
    $sql="DELETE FROM thread WHERE thread_id=:id ";
    $stmt = $thread->deleteThread($sql);
    if($stmt)
        echo "success";
    else
        echo "false";
}
else{
$reply= new Reply($db);
$reply->setId($_POST['id']);
$sql="DELETE FROM thread_reply WHERE thread_reply_id=:id";
$stmt = $reply->deleteReply($sql);
if($stmt)
   echo "success";
else
    echo "false";

}
