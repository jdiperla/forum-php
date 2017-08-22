<!DOCTYPE html>
<?php
session_start();
require_once "class/Reply.php";
require_once "class/Database.php";
require_once "class/Thread.php";

$database = new Database();
$db = $database->DbConnection();

$thread= new Thread($db);
$thread->setId($_GET['id']);
$sql_1="SELECT thread.* , CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id', thread_file.thread_file_id,'name', thread_file.thread_file_name)),']') as list FROM thread LEFT JOIN thread_file on thread.thread_id=thread_file.thread_file_thread WHERE thread.thread_id=:id GROUP BY thread.thread_id";
$stmt_1 = $thread->selectOneThread($sql_1);
$result_1 = $stmt_1->fetchAll();

$reply= new Reply($db);
$reply->setThread($_GET['id']);
$sql_2="SELECT thread_reply.* , CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id', reply_file.reply_file_id,'name', reply_file.reply_file_name)),']') as list FROM thread_reply LEFT JOIN reply_file on thread_reply.thread_reply_id=reply_file.reply_file_reply WHERE thread_reply.thread_reply_thread=:id GROUP BY thread_reply.thread_reply_id";
$stmt_2 = $reply->selectMutiReply($sql_2);
?>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>

        $(document).ready(function()
        {
            $("#tdelete").click(function() {
                //Do stuff when clicked
                var stringarray = $(this).val().split(" ");
                var id=stringarray[0];
                var type=stringarray[1];

                $.ajax
                ({
                    url: 'function/delete.php',
                    data: {"id": id ,"type": type},
                    type: 'post',
                    success: function(result)
                    {
                        if(result=="success")
                        {
                            alert("ok");
                        window.location.replace("index.php");
                        }
                        else {
                          alert("error");
                        }
                    },
                    error: function(result){
                        alert(result);
                    }
                });
                return false;
            });

            $("#rdelete").click(function() {
                //Do stuff when clicked
                var stringarray = $(this).val().split(" ");
                var id=stringarray[0];
                var type=stringarray[1];

                $.ajax
                ({
                    url: 'function/delete.php',
                    data: {"id": id ,"type": type},
                    type: 'post',
                    success: function(result)
                    {
                        if(result=="success")
                        {
                            alert("ok");
                            location.reload();
                        }
                        else {
                            alert("error");
                        }
                    },
                    error: function(result){
                        alert(result);
                    }
                });
                return false;
            });
        });
    </script>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
            text-align: left;
        }

        th {
            width: 30%;
            background-color: #eee;
        }

    </style>
    <?php
    if ($stmt_1 && count($result_1) >0) {
        foreach ($result_1 as $row) {
            ?>
            <title><?=$row['category']?>:<?=$row['thread_title']?></title>
            <?php
        }
    }
    ?>
</head>
<body>
<?php
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    ?>
    <nav>
    <b>Hello <?= $_SESSION['username'] ?></b> |
    <a href="logout.php">Logout</a> |
    <a href="index.php">Return to index</a> |
    <a href="category.php?type=<?=$_GET['type']?>">Return to category page</a> |
    <a href="changepassword.php">Change password</a> 
    </nav>
    <?php
} else {
    ?>
    <nav>
    <a href="login.php">Login</a> |
    <a href="reg.php">Register</a> |
    <a href="index.php">Return to index</a> |
    <a href="category.php?type=<?=$_GET['type']?>">Return to category page</a>
    </nav>
    <?php
}
if ($stmt_1 && count($result_1) >0) {
    foreach($result_1 as $row) {
        ?>
        <h2>Category:<?= $row['category'] ?></h2>
        <h2>Thread Topic: <?= $row['thread_title'] ?></h2>
        <?php
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            ?>
            <a href="addreply.php?id=<?= $row['thread_id'] ?>&type=<?=$_GET['type']?>">Add a reply</a><br/>
            <br/>
            <?php
        }
        ?>
        <table style="width:40%">
            <tr>
                <th rowspan="2">UserName:</th>
            </tr>
            <tr>
                <td><?= $row['username'] ?></td>
            </tr>
            <tr>
                <th rowspan="2">Time:</th>
            </tr>
            <tr>
                <td><?= $row['time'] ?></td>
            </tr>
            <tr>
                <th rowspan="2">Thread topic:</th>
            </tr>
            <tr>
                <td><?= $row['thread_title'] ?></td>
            </tr>
            <tr>
                <th rowspan="2">Topic message:</th>
            </tr>
            <tr>
                <td><?= $row['thread_message_topic'] ?></td>
            </tr>
        </table>
        <?php
        $list = json_decode($row['list'], true);
        $i = 0;
        $len = count($list);
        if ($len > 0 && $list[0]['name'] != null) {
            echo "File Attachment:";
            foreach ($list as $value) {
                echo "<a href=\"download.php?id=" . $value['id'] . "&type=thread\">" . $value['name'] . "</a>";
                if ($i == $len - 1) {
                    continue;
                }
                echo ", ";
                $i++;
            }
        }

        if (isset($_SESSION['username']) && !empty($_SESSION['username']) && $_SESSION['role'] == "admin") {
            ?>
            <br/>
            <button id="tdelete" value="<?=$row['thread_id']?> thread">Delete</button>
            <?php
        }
    }
if($stmt_2 && $stmt_2->rowCount() > 0){
        ?>
<h4>Number of Reply:<?=$stmt_2->rowCount()?></h4>
<?php
    $number=1;
while($row2=$stmt_2->fetch(PDO::FETCH_ASSOC)){
?>
    <p>Reply#<?=$number?></p>
    <table style="width:40%">
        <tr>
            <th>UserName:</th>
            <td><?=$row2['thread_reply_user']?></td>
        </tr>
        <tr>
            <th>Time:</th>
            <td><?=$row2['time']?></td>
        </tr>
        <tr>
            <th>Reply message:</th>
            <td><?=$row2['thread_reply_content']?></td>
        </tr>
    </table>
<?php
    $list=json_decode($row2['list'] ,true);
    $i = 0;
    $len = count($list);
    if($len >0 && $list[0]['name']!=null) {
        echo "File Attachment:";
        foreach ($list as $value) {
            echo "<a href=\"download.php?id=".$value['id'] ."&type=reply\">" . $value['name'] . "</a>";
            if ($i  == $len - 1) {
                continue;
            }
            echo ", ";
            $i++;
        }
    }
if(isset($_SESSION['username']) && !empty($_SESSION['username']) && $_SESSION['role']=="admin") {
?>
<br/>
<button id="rdelete" value="<?=$row2['thread_reply_id']?> reply">Delete</button>
        <?php
}
        $number++;
}
    }
else{
    echo "<h4>Number of Reply:0</h4>";
}
}
else{
    echo "error";
}
?>
</body>
</html>
