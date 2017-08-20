<?php
include_once 'Database.php';
/**
 * Created by PhpStorm.
 * User: Paul
 * Date: 17/8/2017
 * Time: 20:39
 */

class Reply
{
private $id;
private $thread;
private $time;
private $content;
private $user;
private $attachment=array();

private $conn;
private $aid;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

    }

    public function selectMutiReply($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->thread);
        $stmt->execute();
        return $stmt;

    }

    public function selectReplyAttachment($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->thread);
        $stmt->execute();
        return $stmt;
    }

    public function selectAttachment($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->aid);
        $stmt->execute();
        return $stmt;
    }

    public function insertReply($sql){
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user', $this->user);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':time', $this->time);
        $stmt->bindParam(':thread', $this->thread);
        if($stmt->execute()){
            $id = $this->conn->lastInsertId();
            return $id;
        }
        else{
            return false;
        }

    }

    public function insertAttachment($sql)
    {
        $stmt = $this->conn->prepare($sql);
        if (count($this->attachment) > 0) {
            foreach ($this->attachment as $rows) {
                $stmt->bindParam(':name', $rows['name']);
                $stmt->bindParam(':mime', $rows['mime']);
                $stmt->bindParam(':size', $rows['size']);
                $stmt->bindParam(':content', $rows['content'] ,PDO::PARAM_LOB);
                $stmt->bindParam(':reply', $rows['reply']);
                if ($stmt->execute()) {
                    continue;
                } else {
                    return false;
                }
            }
            return true;
        }
    }
    public function deleteReply($sql){
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * @param mixed $thread
     */
    public function setThread($thread)
    {
        $this->thread = $thread;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param array $attachment
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
    }

    /**
     * @return mixed
     */
    public function getAid()
    {
        return $this->aid;
    }

    /**
     * @param mixed $aid
     */
    public function setAid($aid)
    {
        $this->aid = $aid;
    }





}

//select m reply
/*
$database = new Database();
$db = $database->DbConnection();
$reply= new Reply($db);
$reply->setThread(12);
$sql="SELECT thread_reply.* , GROUP_CONCAT(JSON_OBJECT('id', reply_file.reply_file_id,'name', reply_file.reply_file_name)) as list FROM thread_reply LEFT JOIN reply_file on thread_reply.thread_reply_id=reply_file.reply_file_reply WHERE thread_reply.thread_reply_thread=:id GROUP BY thread_reply.thread_reply_id";
$stmt = $reply->selectMutiReply($sql);
if($stmt)
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        echo $row['thread_reply_id'] .  ":" . $row['thread_reply_content'];
        echo "<br>";
    }
else
    echo "false";
*/

//select a
/*
$database = new Database();
$db = $database->DbConnection();
$reply= new Reply($db);
$reply->setAid(1);
$sql="SELECT * FROM reply_file WHERE reply_file_id=:id";
$stmt = $reply->selectAttachment($sql);
if($stmt)
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        echo $row['reply_file_id'] .  ":" . $row['reply_file_name'];
        echo "<br>";
    }
else
    echo "false";
*/

//insert thread
/*
date_default_timezone_set('Asia/Hong_Kong');
$time=date('Y-m-d H:i:s');
$database = new Database();
$db = $database->DbConnection();
$reply= new Reply($db);
$reply->setContent("test123");
$reply->setTime($time);
$reply->setUser("test");
$reply->setThread(12);
$sql="INSERT INTO thread_reply(thread_reply_content, time, thread_reply_user, thread_reply_thread) VALUES (:content,:time,:user,:thread)";
$stmt = $reply->insertReply($sql);
if($stmt){
echo "$stmt";
}
else {
    echo "false";
}
$number=$stmt;
$file=file_get_contents("ok.jpg");
$reply->setAttachment(array(array("name"=>"abc.php", "mime"=>"php", "content"=>"$file", "reply"=>"$number"),array("name"=>"abc.php", "mime"=>"php", "content"=>"$file", "reply"=>"$number")));
$sql_1="INSERT INTO reply_file(reply_file_name, reply_file_mime, reply_file_content, reply_file_reply) VALUES (:name, :mime, :content ,:reply)";
$stmt_1 = $reply->insertAttachment($sql_1);
if($stmt_1){
    echo "true";
}
else{
    echo "false_file";
}
*/

//delete
/*
$database = new Database();
$db = $database->DbConnection();
$reply= new Reply($db);
$reply->setId(2);
$sql="DELETE FROM reply WHERE reply_id=:id";
$stmt = $reply->deleteReply($sql);
if($stmt)
   echo "true";
else
    echo "false";
*/
