<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubscribe</title>
    <style>
        body{
            margin:0px;
            padding:0px;
        }
        #form_content{
            border: 1px solid black;
            position: relative;
            width: 800px;
            margin: auto;
            box-shadow: 5px 5px 5px black;
            text-align: center;
            min-height: 200px;
            top: 50px;
        }
    </style>
</head>
<body>
    <div id="form_content">
    <?php
    require __DIR__.'/helperfuncs.php';
    // $link = getLink();
    ?>
    <?php if($_GET['unsubalready'])
    { ?>

        <h1>Already unsubscribed</h1>
    <?php } 
    else{ ?>
        <h1>Unsubscribed Successfully</h1>
    <?php } ?>
    <h3>You will no longer receive any new comics from us. Although if you want to start receiving comics, register yourself on our website again!</h3>
    <h4>Want to subscribe again! </h4>
    <br><hr>
    <a href="http://localhost/chirag/rtcamp_assignment/index.php">« Return to our website</a>
    </div>
</body>
</html>