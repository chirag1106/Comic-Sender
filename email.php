<?php
$idpass_err=false;
if(defined('STDIN')){
    if(isset($argv[1]) && isset($argv[2])){
        $id = $argv[1];
        $password = $argv[2];
    }
    else{
        $idpass_err=true;
        echo 'Enter id and password then try again.';
    }
} 
else{
    if(isset($_GET['id']) && !empty($_GET['id'])){
        $id = $_GET['id'];
    }else{
        $id = "";
    }
    if(isset($_GET['password']) && !empty($_GET['password'])){
        $password = $_GET['password'];
    }else{
        $id = "";
    }
}

if($id && $password)
{
    if($id==='admin' and $password==='comic@admin123')
    {   
        require_once __DIR__.'/config.php';
        require __DIR__.'/helperfuncs.php';
        $sql = 'SELECT * FROM users WHERE status=1';
        $result = $conn->query($sql);
        $emails = array();
        $token = array();
        while ($row = $result->fetch_assoc()) 
        {
            array_push($emails,$row['email']);
            array_push($token,$row['token']);
        }

        $url = Url();
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
        $release_date=date('Y-m-d',$release_date_ts);
        $date=date_create($release_date);
        $rel_date=date_format($date,"l, F jS, Y");

        for($i=0; $i<count($emails); $i++){ 
            try {		

                $mail->addAddress($emails[$i]);
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
                <h4 style="font-size:15px;">Hi '.$emails[$i].',</h4><br>
                <div class="container">
                <div class="header">
                <span style="position:relative;top:4px;font-size: 25px;"><strong>'.$comic_data['safe_title'].'<strong></span>
                </div>
                <div class="mainbody" style="margin-top:5px;margin-left: 7px;">
                    <img src='.$comic_data['img'].' style="height:400px;width:96%;">
                    <p style="font-size:15px;">'.$comic_data['transcript'].'</p>
                </div>
                <div class="footer">
                    <h3>This Comic was released on '.$rel_date.'</h3>
                </div>
                </div>
                <div style="margin-left:13px;">If you would prefer not to receive comics in future from us
                <a href="https://www.comicsender.me/unsubscribe.php?email='.$emails[$i].'&token='.$token[$i].'" style="color:red;font-size:15px;">unsubscribe here.</a></div>
                </body>
                </html>
                ';
                $mail->Body = $message;
                $mail->send();
                $mail->clearAttachments();
                $mail->ClearAllRecipients();
                echo 'Mail has been sent successfully!';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
    else{
        echo 'Access Denied';
    }
}
else{
    if(!$idpass_err){
        echo 'Access Denied';
    }
}
?>
