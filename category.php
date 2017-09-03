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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        @import url(http://fonts.googleapis.com/css?family=Oswald:400,300,700);
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
        
        .navbar{
            font-family:'Oswald';
        }
        .navbar-brand{
            font-size: 25px;
        }
        .navbar-nav{
            font-size: 16px;
        }
        #content{
            padding-left: 10px;
        }
       
    </style>
    <title><?=$_GET['type']?></title>
</head>
<body>
<div class="container">
<?php
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    ?>
    <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
    <a class="navbar-brand" href="index.php"><b>Study Forum</b></a>
    </div>
    <ul class="nav navbar-nav">
      <li><p class="navbar-text">Hello <?= $_SESSION['username'] ?></p></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="logout.php">Logout</a></li>
      <li><a href="changepassword.php">Change password</a></li>
    </ul>
    
  </div>
</nav>
    
    <?php
} else {
    ?>
     <nav class="navbar navbar-default">
     <div class="container-fluid">
       <div class="navbar-header">
       <a class="navbar-brand" href="index.php"><b>Study Forum</b></a>
       </div>
       <ul class="nav navbar-nav navbar-right">
         <li><a href="login.php">Login</a> </li>
         <li><a href="reg.php">Register</a></li>
       </ul>
     </div>
   </nav>
    <?php
}
?>
<div id="content">
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
</div>
</div>
</body>
</html>
