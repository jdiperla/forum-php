<?php
session_start();
if (!isset($_SESSION['username']) && empty($_SESSION['username'])) {
            header("Location: index.php", true, 301);
            exit();
        }
require_once('class/Database.php');
require_once('class/Thread.php');
require_once('class/Reply.php');

$database = new Database();
$db = $database->DbConnection();
if ($_GET['type'] == "thread") {
    $thread = new Thread($db);
    $thread->setAid($_GET['id']);
    $sql = "SELECT * FROM thread_file WHERE thread_file_id=:id";
    $stmt = $thread->selectAttachment($sql);
    if ($stmt) {
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $type = $row[0]['thread_file_mime'];
        $size = $row[0]['thread_file_size'];
        $name = $row[0]['thread_file_name'];
        $content = $row[0]['thread_file_content'];
        header("Content-type: $type");
        header("Content-length: $size");
        header("Content-Disposition: attachment; filename=$name");
        echo $content;
    } else {
        echo "false";
    }
} else {
    $reply = new Reply($db);
    $reply->setAid($_GET['id']);
    $sql = "SELECT * FROM reply_file WHERE reply_file_id=:id";
    $stmt = $reply->selectAttachment($sql);
    if ($stmt) {
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $type = $row[0]['reply_file_mime'];
        $size = $row[0]['reply_file_size'];
        $name = $row[0]['reply_file_name'];
        $content = $row[0]['reply_file_content'];

        header("Content-type: $type");
        header("Content-length: $size");
        header("Content-Disposition: attachment; filename=$name");
        echo $content;
    } else {
        echo "false";
    }
}