<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add a Reply</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>
        $(document).ready(function()
        {
            $('#replyform').submit(function(e){
                e.preventDefault();
                var form_data = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: 'function/addreply.php',
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result){
                         if(result=="success")
                            {
                               window.location.href = document.referrer;
                            }
                            else {
                               alert(result); 
                            }
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
if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    ?>
    <nav>
    <b>Hello <?= $_SESSION['username'] ?></b> |
    <a href="logout.php">Logout</a> |
    <a href="index.php">Return to home page</a> |
    <a href="thread.php?id=<?=$_GET['id']?>&type=<?=$_GET['type']?>">Return to thread page</a>
    </nav>
    <?php
}
else{
    header("Location: ../index.php", true, 301);
    exit();
    ?>
    <?php

}
?>
<h2>Add reply</h2>
<form id="replyform" method="post" enctype="multipart/form-data" >
    <label for="content">Reply Message Body:</label><br/>
    <textarea rows="5" cols="30" name="content" id="content"></textarea><br/><br/>
    <label for="attachment"><b>Attachments:</b></label><br/>
    <div>
        <input type="file" name="files[]" multiple="" />
    </div><br/>
    <input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
    <input type="submit" value="OK"/>
</form>
</body>
</html>
