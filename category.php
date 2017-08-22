<?php
session_start();
require_once "class/Thread.php";
require_once "class/Database.php";

$database = new Database();
$db = $database->DbConnection();
$thread = new Thread($db);
$thread->setType($_GET['type']);
$sql = "SELECT * FROM thread WHERE category=:type ORDER BY thread_id";
$stmt = $thread->selectMutiThread($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 50%;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
            text-align: left;
        }

        table#t01 tr:nth-child(even) {
            background-color: #eee;
        }

        table#t01 tr:nth-child(odd) {
            background-color: #fff;
        }

        table#t01 th {
            background-color: black;
            color: white;
        }
    </style>
    <title><?=$_GET['type']?></title>
</head>
<body>
<?php
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    ?>
    <nav>
    <b>Hello <?= $_SESSION['username'] ?></b> |
    <a href="logout.php">Logout</a> |
    <a href="index.php">Return to home page</a> |
    <a href="changepassword.php">Change password</a> 
    </nav>
    <?php
} else {
    ?>
    <nav>
    <a href="login.php">Login</a> |
    <a href="reg.php">Register</a> |
    <a href="index.php">Return to home page</a> 
    </nav>
    <?php
}
?>
<h2><?=$_GET['type']?> Topic</h2>
<?php
if (isset($_SESSION['username']) && !empty($_SESSION['username']) && $stmt) {
    ?>
    <h3>Number of Topics:<?= $stmt->rowCount() ?></h3>
    <a href="addthread.php?type=<?=$_GET['type']?>">Create a Thread</a><br/><br/>
    <?php
} else if(!isset($_SESSION['username']) && empty($_SESSION['username']) && $stmt){
    ?>
    <h3>Number of Topics:<?= $stmt->rowCount() ?></h3>
    <?php
}
else {
    ?>
    <h3>error</h3>
    <?php
}
if ($stmt && $stmt->rowCount() > 0){
?>
<table id="t01">
    <tr>
        <th>Thread Topic</th>
        <th>User</th>
        <th>Time</th>
    </tr>
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td><a href='thread.php?id=" . $row['thread_id'] . "&type=" . $_GET['type'] . "'>" . $row['thread_title'] . "</a></td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['time'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    }
    else if($stmt && $stmt->rowCount() == 0) {
        echo "";
    }
    else {
        echo "<p>error</p>";
    }
    ?>

</body>
</html>
