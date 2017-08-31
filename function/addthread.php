<?php
session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: ../index.php", true, 301);
    exit;
}
require_once('../class/Database.php');
require_once('../class/Thread.php');

date_default_timezone_set('Asia/Hong_Kong');
$time=date('Y-m-d H:i:s');
$database = new Database();
$db = $database->DbConnection();
$thread= new Thread($db);
$thread->setTitle(htmlspecialchars($_POST['topic']));
$thread->setContent(htmlspecialchars($_POST['content']));
$thread->setType(htmlspecialchars($_POST['type']));
$thread->setTime($time);
$thread->setUser(htmlspecialchars($_SESSION['username']));
$sql="INSERT INTO thread(thread_title, thread_message_topic, category, time, username) VALUES (:title ,:content ,:type,:time,:user)";
$stmt = $thread->insertThread($sql);
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
    echo $number;
    exit;
}
foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
    $file=array();
    $file['name'] =$_FILES['files']['name'][$key];
    $file['mime']=$_FILES['files']['type'][$key];
    $file['size']=$_FILES['files']['size'][$key];
    $file['content'] =file_get_contents($_FILES['files']['tmp_name'][$key]);
    $file['thread']=$number;
    array_push($files,$file);
}
$thread->setAttachment($files);
$sql_1="INSERT INTO thread_file(thread_file_name, thread_file_mime, thread_file_size, thread_file_content, thread_file_thread) VALUES (:name, :mime, :size, :content ,:thread)";
$stmt_1 = $thread->insertAttachment($sql_1);
if($stmt_1){
    echo $number;
}
else{
    echo "false_file";
}

