<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: ../index.php", true, 301);
    exit;
}
require_once('../class/Database.php');
require_once('../class/Reply.php');
date_default_timezone_set('Asia/Hong_Kong');
$time=date('Y-m-d H:i:s');
$database = new Database();
$db = $database->DbConnection();
$reply= new Reply($db);
$reply->setContent($_POST['content']);
$reply->setTime($time);
$reply->setUser($_SESSION['username']);
$reply->setThread($_POST['id']);
$sql="INSERT INTO thread_reply(thread_reply_content, time, thread_reply_user, thread_reply_thread) VALUES (:content,:time,:user,:thread)";
$stmt = $reply->insertReply($sql);
$number=null;
if($stmt){
    $number=$stmt;
}
else {
    echo "false";
    exit;
}
$files=array();
if(in_array("", $_FILES['files']['name'])){
    echo "success";
    exit;
}
foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
    $file=array();
    $file['name'] =$_FILES['files']['name'][$key];
    $file['mime']=$_FILES['files']['type'][$key];
    $file['size']=$_FILES['files']['size'][$key];
    $file['content'] =file_get_contents($_FILES['files']['tmp_name'][$key]);
    $file['reply']=$number;
    array_push($files,$file);
}
$reply->setAttachment($files);
$sql_1="INSERT INTO reply_file(reply_file_name, reply_file_mime, reply_file_size, reply_file_content, reply_file_reply) VALUES (:name, :mime ,:size ,:content ,:reply)";
$stmt_1 = $reply->insertAttachment($sql_1);
if($stmt_1){
    echo "success";
}
else{
    echo $stmt_1->errorInfo();
}


?>