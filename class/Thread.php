<?php
include_once 'Database.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Thread
 *
 * @author Paul
 */
class Thread {
    //put your code here
    private $id='';
    private $title='';
    private $user='';
    private $time='';
    private $content='';
    private $type='';
    private $attachment=array();
    private $aid;
    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
        $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );

    }


    public function selectOneThread($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->id);
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

    public function selectMutiThread($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':type', $this->type);
        $stmt->execute();
       return $stmt;

    }

    public function insertThread($sql){
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':user', $this->user);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':time', $this->time);
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
                $stmt->bindParam(':content', $rows['content'] , PDO::PARAM_LOB);
                $stmt->bindParam(':thread', $rows['thread']);
                if ($stmt->execute()) {
                    continue;
                } else {
                    return false;
                }
            }
            return true;
        }
    }


    public function deleteThread($sql){
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
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

//select thread
/*
$database = new Database();
$db = $database->DbConnection();
$thread= new Thread($db);
$thread->setId(15);
$sql="SELECT thread.* , GROUP_CONCAT(JSON_OBJECT('id', thread_file.thread_file_id,'name', thread_file.thread_file_name)) as list FROM thread LEFT JOIN thread_file on thread.thread_id=thread_file.thread_file_thread WHERE thread.thread_id=:id GROUP BY thread.thread_id";
$stmt = $thread->selectOneThread($sql);
if($stmt)
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        echo $row['thread_id'] .  ":" . $row['thread_file_name'];
        echo "<br>";
    }
else
    echo "false";
*/

//select a
/*
$database = new Database();
$db = $database->DbConnection();
$thread= new Thread($db);
$thread->setAid(15);
$sql="SELECT * FROM thread_file WHERE thread_file_id=:id";
$stmt = $thread->selectAttachment($sql);
if($stmt)
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        echo $row['thread_file_id'] .  ":" . $row['thread_file_name'];
        echo "<br>";
    }
else
    echo "false";
*/

//select m thread
/*
$database = new Database();
$db = $database->DbConnection();
$thread= new Thread($db);
$thread->setType("other");
$sql="SELECT * FROM thread WHERE category=:type";
$stmt = $thread->selectMutiThread($sql);
if($stmt)
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        echo $row['thread_id'] .  ":" . $row['thread_title'];
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
$thread= new Thread($db);
$thread->setTitle("Test5");
$thread->setContent("test123");
$thread->setType("other");
$thread->setTime($time);
$thread->setUser("test");
$sql="INSERT INTO thread(thread_title, thread_message_topic, category, time, username) VALUES (:title ,:content ,:type,:time,:user)";
$stmt = $thread->insertThread($sql);
if($stmt){
echo "$stmt";
}
else {
    echo "false";
}
$number=$stmt;
$file=file_get_contents("ok.jpg");
$thread->setAttachment(array(array("name"=>"abc.php", "mime"=>"php", "content"=>"$file", "thread"=>"$number"),array("name"=>"abc.php", "mime"=>"php", "content"=>"$file", "thread"=>"$number")));
$sql_1="INSERT INTO thread_file(thread_file_name, thread_file_mime, thread_file_content, thread_file_thread) VALUES (:name, :mime, :content ,:thread)";
$stmt_1 = $thread->insertAttachment($sql_1);
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
$thread= new Thread($db);
$thread->setId(2);
$sql="DELETE FROM thread WHERE thread_id=:id ";
$stmt = $thread->deleteThread($sql);
if($stmt)
   echo "true";
else
    echo "false";
*/
