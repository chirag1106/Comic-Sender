<?php

require_once __DIR__.'/config.php';
require_once __DIR__.'/helperfuncs.php';

if(isset($_POST['register']) && !empty($_POST['email']))
{
    $message='';
    $email = $_POST['email'];
    $url = Url();

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false)
    {
        $sql = "select * from users where email = '$email'";
        $result = $conn->query($sql);

        if($result->num_rows >= 1)
        {
            $row = $result->fetch_assoc();
            if($row['status'] == '1')
            {
                $message = 'Email is already registered and active for receiving comics';
            }
            else
            {
                $token = md5(rand(0,1000));
                $sql = "UPDATE users set token = ? WHERE email = ? ";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $token, $email);
                $stmt->execute();
                
                $mail->Subject = "Please verify your account";
                try
                {
                    $mail->addAddress($email);
                    $emessage = '
                        <html>
                            <head>
                                <meta name="viewport" content="width=device-width" />
                                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                                <style>
                                table {
                                    border-collapse: collapse;
                                    background-color:beige;
                                    max-width: 800px;
                                    margin: auto;
                                    border-radius: 10px;
                                    box-shadow: 5px 10px 18px #888888;
                                    height:300px;
                                }
                                td{
                                    text-align: left;
                                    padding-left: 15px;
                                }
                                tr:nth-child(even){background-color: #808080}
                                tr:nth-child(odd){background-color: #808080}
                                
                                th {
                                    background-color: #4CAF50;
                                    color: white;
                                    font-size:15px;
                                }
                                th p{
                                    margin: 0px;
                                    font-size: 25px;
                                }
                                tr td h3{
                                    margin:0px;
                                    padding-top:5px;
                                    padding-bottom: 5px;
                                    font-family: emoji;
                                }
                                #footer{
                                    margin: 0px;
                                    padding: 0px;
                                    background-color: #4CAF50;
                                    color: white;
                                    font-size:13px;
                                }
                                table tr td #link{ 
                                    background-color:orange;
                                    margin: 5px;
                                    padding: 5px;
                                    border-radius: 10px;
                                    color: white;
                                    text-decoration: none;
                                    font-size:15px;
                                }
                                table tr td #link:hover{
                                    color: blue;
                                }
                                </style>
                            </head>
                            <body>
                            <table style>
                            <tr>
                              <th><p align="center"><b>Comic Reader</b></p></th>
                            </tr>
                            <tr>
                              <td><h3>Verify Your Email ID:</h3></td>
                            </tr>
                            <tr>
                              <td>For verifying click on: <a href="'.$url.'/emailverify.php?email='.$email.'&token='.$token.'" target="_blank" id="link">verify email</a></td>
                            </tr>
                            <br>
                            <tr>
                              <td>If you received this email by mistake, simply delete it. Your will not be subscribed if you do not click the confirmation link above.</td>
                            </tr>
                            <tr>
                              <td id="footer"><p align="center">Copyright © 2021 By  <a href="https://www.comicsender.me" style="text-decoration:none;color:#20c;a:hover{
                                color: #45e;
                                text-decoration: underline;
                            } ">www.comicsender.me</a></p></td>
                            </tr>
                            </table>
                            <br><br>
                            </body>
                        </html>
                    ';

                    $mail->Body = $emessage;
                    $mail->send();
                    $mail->clearAttachments();
                    $mail->ClearAllRecipients();
                }
                catch(Exception $e)
                {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                $message = 'Thank you for registering, please click on the link received on your email for verification.';
            }
        }
        else{
            $token = md5( rand(0,1000) );
            $status = 0;
            $sql = 'INSERT INTO users(`email`, `token`, `status`) VALUES (?,?,?)';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $email, $token, $status);
            $result = $stmt->execute();
            if($result)
            {
                $mail->Subject = 'Confirm your Email';
                try
                {
                    $mail->addAddress($email);
                    $emessage = '
                        <html>
                            <head>
                                <meta name="viewport" content="width=device-width" />
                                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                                <style>
                                table {
                                    border-collapse: collapse;
                                    background-color:beige;
                                    max-width: 800px;
                                    margin: auto;
                                    border-radius: 10px;
                                    box-shadow: 5px 10px 18px #888888;
                                }
                                td{
                                    text-align: left;
                                    padding-left: 15px;
                                }
                                tr:nth-child(even){background-color: #808080}
                                tr:nth-child(odd){background-color: #808080}
                                
                                th {
                                    background-color: #4CAF50;
                                    color: white;
                                    font-size:15px;
                                }
                                th p{
                                    margin: 0px;
                                    font-size: 25px;
                                }
                                tr td h3{
                                    margin:0px;
                                    padding-top:5px;
                                    padding-bottom: 5px;
                                    font-family: emoji;
                                }
                                table tr td #link{ 
                                    background-color:orange;
                                    margin: 5px;
                                    padding: 5px;
                                    border-radius: 10px;
                                    color: white;
                                    text-decoration: none;
                                    font-size:15px;
                                }
                                table tr td #link:hover{
                                    color: blue;
                                }
                                </style>
                            </head>
                            <body>
                            <table style>
                            <tr>
                              <th><p align="center"><b>Comic Reader</b></p></th>
                            </tr>
                            <tr>
                              <td><h3>Verify Your Email ID:</h3></td>
                            </tr>
                            <tr>
                              <td>For verifying click on: <a href="<a href="'.$url.'/emailverify.php?email='.$email.'&token='.$token.'" target="_blank" id="link">verify email</a></td>
                            </tr>
                            <br>
                            <tr>
                              <td>If you received this email by mistake, simply delete it. Your will not be subscribed if you do not click the confirmation link above.</td>
                            </tr>
                            <tr>
                            <td id="footer"><p align="center">Copyright © 2021 By  <a href="https://www.comicsender.me" style="text-decoration:none;color:#20c;a:hover{
                                color: #45e;
                                text-decoration: underline;
                            } ">www.comicsender.me</a></p></td>
                            </tr>
                            </table>
                            <br><br>
                            </body>
                        </html>
                    ';

                    $mail->Body = $emessage;
                    $mail->send();
                    $mail->clearAttachments();
                    $mail->ClearAllRecipients();
                }
                catch(Exception $e)
                {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                $message = 'For receiving comics, please click on the link received in your email.';
            }
            else{
                $message='SQL Error!';
            }
        }  
    }
    else
    {
        $message='Please enter a valid email';
    }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage | Comics</title>
    <link rel="stylesheet" href="stylesheet.css?v=<?php echo time(); ?>">

</head> 
<body onload="message()">
    <div id="super_container">
    <div class="container">
    <form method="POST">
        <h1>Register</h1>
        <p>Registration for getting different comics every 5 minutes.</p>
        <hr>
        <input type="email" name="email" id="email" placeholder="Enter your E-mail" required>
        <hr>
        <button type="submit" class="registerbtn" name="register">Register</button>
    </form>
    </div>
    </div>

    <div id="error_msg">
        <?php
        if(!empty($message)){
            echo $message;
        }
        ?>
    </div>

    <script type="text/javascript">
        function message(){
            var x = document.getElementById('error_msg');
            if(x.textContent.length != 21){
                x.className="show";
            }
            // After 3 seconds, remove the show class from DIV
            setTimeout(function(){ x.className = x.className.replace("show", "") }, 5000);

        }
    </script>
</body>
</html>