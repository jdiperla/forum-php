<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create a Thread</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#threadform').submit(function (e) {
                e.preventDefault();
                var form_data = new FormData(this);
                
                $.ajax({
                    type: 'POST',
                    url: 'function/addthread.php',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {             
        window.location.replace("thread.php?id="+result+"&type=<?= $_GET['type']?>")
                    },
                    error: function (error) {
                        alert(error);
                    }
                });
            });
        });
    </script>
</head>
<body>
<?php
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    ?>
    <nav>
    <b>Hello <?= $_SESSION['username'] ?></b> |
    <a href="logout.php">Logout</a> |
    <a href="index.php">Return to home page</a> |
    <a href="category.php?type=<?=$_GET['type']?>">Return to category page</a>
    </nav>
    <?php
} else {
    header("Location: ../index.php", true, 301);
    exit();
    ?>
    <?php
}
?>
<h2>Create a Thread</h2>
<form id="threadform" method="post" enctype="multipart/form-data">
    <label for="topic">Thread Topic:</label><br/>
    <input type="text" id="topic" name="topic" required/><br/><br/>
    <label for="content">Thread Message:</label><br/>
    <textarea rows="5" cols="30" name="content" id="content"></textarea><br/><br/>
    <label for="attachment"><b>Attachments:</b></label><br/>
    <div>
        <input type="file" name="files[]" multiple=""/>
    </div>
    <br/>
    <input type="hidden" id="type" name="type" value="<?= $_GET['type'] ?>"/>
    <input type="submit" value="OK"/>
</form>
</body>
</html>
