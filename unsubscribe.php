<?php

require_once __DIR__.'/config.php';
require __DIR__.'/helperfuncs.php';
// $link = getLink();

// flag will be true if subscribe as successful else it wil false.
$flag=true; 
if (isset($_POST['email']) and $_POST['token'])
{
    $email = $_POST['email'];
    $token = $_POST['token'];
    // Removing the illegal characters from email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    //Validating
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false)
    {
        $flag = true;
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
  
        if($result->num_rows == 0)
        {
          $flag = false;
        }

        if ($row['status'] == '0') 
        {
            header('Location: unsubscribe_success.php?unsubalready=1');
            exit();
        }

        if ($row['status'] == '1')
        {
            if($token == $row['token'])
            {
                $flag=true;
                $activate = 0;
                $token = '';
                $sql = 'UPDATE users SET status = ?, token = ? WHERE email = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $activate, $token, $email);
                $result = $stmt->execute();	
                header('Location: unsubscribe_success.php?unsubalready=0');
                exit();
            }  
            else
            {
                $flag = false;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsubcribe</title>
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
            height: 200px;
            top: 50px;
        }
    </style>
</head>
<body>
    <?php 
    if($flag)
    { 
    ?>
    <div id="form_content">
    <form method="POST" action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> ">
        <input type="hidden" name="email" value="<?php echo $_GET["email"]; ?>">
        <input type="hidden" name="token" value="<?php echo $_GET["token"]; ?>">
        <h3>Are you sure, you want to unsubscribe?</h3>
        <input type="submit" name="submit" value="Unsubscribe">
        <br><hr>
        <a href="http://localhost/chirag/rtcamp_assignment/index.php">« Return to our website</a>
    </form>
    </div>
    <?php 
    } 
    else
    {
    ?> 
    <div id="form_content">
    <form method="POST" action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> ">
        <!-- <input type="hidden" name="email" value="<?php echo $_GET["email"]; ?>"> -->
        <h3>Some error occured! Please try again</h3>
        <hr>
        <a href="http://localhost/chirag/rtcamp_assignment/index.php">« Return to our website</a>
    </form>
    </div>
    <?php     
    }
    ?>
</body>
</html>