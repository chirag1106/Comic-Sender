<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <style>
        /* .loader{
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            background-color: #16191e;
            position: absolute;
        }
        .loader>div{
            height: 100px;
            width: 100px;
            border: 15px solid #45474b;
            border-top-color: #2a88e6;
            position: absolute;
            margin: auto;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            border-radius: 50%;
            animation: spin 1.5s infinite linear;
        }
        @keyframes spin{
            100%{
                transform: rotate(360deg);
            }
        } */
        .success,.ald-verify,.failure{
            display: grid;
            place-items: center;
            border: 1px solid black;
            text-align: center;
            min-height: 200px;
            width: 80%;
            margin: auto;
            align-content:center;
            box-shadow: 5px 5px 10px black;
            background-color: beige;
            text-shadow: 2px 1px 10px off whitesmoke;
            color: black;
            position: relative;
            top: 50px;
            
        }
        .success{
            background-color: #c6ffb3;
        }
        .failure{
            background-color: #ff4d4d;
            color: white;
            text-shadow: 2px 1px 10px black;
        }
    </style>
</head>
<body> <!--onload="loader()"-->

        <!-- <div class="loader">
            <div></div>
        </div>  -->
    <?php
        require_once __DIR__.'/config.php';
        require __DIR__.'/helperfuncs.php';
        $email=$_GET['email'];
        $token=$_GET['token'];
        // $link = getLink();

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        //Validating
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false)
        {
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            
            // For checking status before updating it.
            if($row['status']=='1')
            {
                $status=true;
            }
            else
            {
                $status=false;
            }
            
            // for checking token mismatch.
            if($row['token']==$token)
            {
                $token_error=false;
            }
            else
            {
                $token_error=true;
            }
            
            // for activating the status of the registered user.
            if($row['status']=='0')
            {
                if($row['token']==$token)
                {
                    $activate = 1;
                    $sql = 'UPDATE users SET status = ? WHERE email = ?';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('is', $activate, $email);
                    $result=$stmt->execute();
                }
            }
            if($result and !$status and !$token_error){
                // for getting random comic number.
                $comic_id = rand(0,2600);

                // for fetching comic details in an array.
                $comic_data =  getComic($comic_id);

                // email subject
                $mail->Subject = 'Your Comic ['.$comic_data['safe_title'].'] is here!';

                // retrieving month, day, year of comic.
                $month = $comic_data['month'];
                $day = $comic_data['day'];
                $year = $comic_data['year'];    
                $release_date_ts=strtotime("$year-$month-$day");
                // echo $release_date_ts;
                $release_date=date('Y-m-d',$release_date_ts);
                $date=date_create($release_date);
                $rel_date=date_format($date,"l, F jS, Y");
                // echo '<br>';
                // echo $release_date;

                // Sending mail to user.
                try {	
                $mail->addAddress($email);
                
                $message = '
                <html>
                <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <style>
                    .container {
                    width: 500px;
                    margin: 10px;
                    border: 1px solid #fff;
                    background-color: #ffffff;
                    box-shadow: 0px 2px 7px #292929;
                    -moz-box-shadow: 0px 2px 7px #292929;
                    -webkit-box-shadow: 0px 2px 7px #292929;
                    border-radius: 10px;
                    -moz-border-radius: 10px;
                    -webkit-border-radius: 10px;
                }
                .mainbody,
                .header,
                .footer {
                    padding: 5px;
                }
                .mainbody {
                    margin-top: 5px;
                }
                .header {
                    text-align:center;
                    min-height: 40px;
                    height: auto;
                    width: 100%;
                    resize: both;
                    overflow: auto;
                    background-color: whiteSmoke;
                    border-bottom: 1px solid #DDD;
                    border-bottom-left-radius: 5px;
                    border-bottom-right-radius: 5px;
                }
                .footer {
                    height: 40px;
                    background-color: whiteSmoke;
                    border-top: 1px solid #DDD;
                    -webkit-border-bottom-left-radius: 5px;
                    -webkit-border-bottom-right-radius: 5px;
                    -moz-border-radius-bottomleft: 5px;
                    -moz-border-radius-bottomright: 5px;
                    border-bottom-left-radius: 5px;
                    border-bottom-right-radius: 5px;
                }
                </style>
                </head>
                <body>
                <h4 style="font-size:15px;">Hi '.$email.',</h4><br>
                <div class="container">
                <div class="header">
                <span style="position:relative;top:4px;font-size: 25px;"><strong>'.$comic_data['safe_title'].'<strong></span>
                </div>
                <div class="mainbody" style="margin-top:5px;margin-left: 7px;">
                    <img src='.$comic_data['img'].' style="height:400px;width:96%;">
                    <img src="logo.jpeg" style="height:400px;width:96%;">
                    <p style="font-size:15px;">'.$comic_data['transcript'].'</p>
                </div>
                <div class="footer">
                    <h3>This Comic was released on '.$rel_date.'</h3>
                </div>
                </div>
                <div style="margin-left:13px;">If you would prefer not to receive comics in future from us
                <a href="http://localhost/chirag/rtcamp_assignment/unsubscribe.php?email='.$email.'&token='.$token.'" style="color:red;font-size:15px;">unsubscribe here.</a></div>
                </body>
                </html>
                ';
          
                $mail->Body = $message;
                $mail->send();
                $mail->clearAttachments();
                $mail->ClearAllRecipients();
                } 
                catch (Exception $e) 
                {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                
                ?>
                <div class="success">
                    <h1>Congratulations</h1>
                    <p>Your email is successfully verified! You will start receiving comics in your email shortly.</p>
                    <br><hr>
                    <a href="http://localhost/chirag/rtcamp_assignment/index.php">« Return to our website</a>
                </div>
            
                <?php
            }
            elseif($status and !$token_error)
            {
                ?>
                <div class="ald-verify">
                    <h1>Already verified</h1>
                    <p>You are already receiving comics from us, if you don’t find them please check your spam folder.</p>
                    <br><hr>
                    <a href="http://localhost/chirag/rtcamp_assignment/index.php">« Return to our website</a>
                </div>
                <?php
            }
            else
            {
                ?>
                <div class="failure">
                    <h1>Error Occurred</h1>
                    <p>Some error occurred! Please try again.</p>
                    <br><hr>
                    <a href="http://localhost/chirag/rtcamp_assignment/index.php">« Return to our website</a>
                </div>
                <?php
            }
        }
        else
        {
            ?>
            <div class="failure">
                <h1>Error Occurred</h1>
                <p>Some error occurred! Please try again.</p>
                <br><hr>
                <a href="http://localhost/chirag/rtcamp_assignment/index.php">« Return to our website</a>
            </div>
            <?php
        }  
    ?> 


    <!-- <script>
        $(window).on('load',function(){
            $(".loader").fadeOut(1000);
            $(".success").fadeIn(1000);
        });
    </script> -->
</body>
</html>