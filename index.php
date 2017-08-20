<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>Forum</title>
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
            h1 {
                margin-bottom: -5px;
                padding-left: 10px;
            }
            h3 {
                padding-left: 30px;
            }
            ul li{
                margin-bottom:10px;
            }
            .list{
             
                margin-left: -20px;
                width: 300px;
            }

        </style>
    </head>
    <body>
        <?php
        if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            ?>
            <div id="header">
                <nav>
                    <b>Hello <?= $_SESSION['username'] ?></b> |
                    <a href="logout.php">Logout</a>
                </nav>
            </div>
            <?php
        } else {
            ?>
            <div id="header">
                <nav>
                    <a href="login.php">Login</a> |
                    <a href="reg.php">Register</a>
                </nav>
            </div>
            <?php
        }
        ?>
        <div id="contect">
            <h1>Welcome to Forum</h1>
            <div class="list">
                <nav>
                    <h3>Category List</h3>
                    <ul>
                        <li><a href="category.php?type=Lecture">Lecture</a></li>
                        <li><a href="category.php?type=Lab">Lab</a></li>
                        <li><a href="category.php?type=Other">Other</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </body>
</html>
