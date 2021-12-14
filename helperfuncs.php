<?php

    function getLink(){
        if(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https';
        }
        else{
            $protocol = 'http';
        }


        $link = 'http://127.0.0.1:8000';

        return $link;
    }

    // comic api calling
    function getComic($comic_id){
        $url = "https://xkcd.com/".$comic_id."/info.0.json";
       // create & initialize a curl session
        $curl = curl_init();

        // set our url with curl_setopt()
        curl_setopt($curl, CURLOPT_URL, $url);

        // return the transfer as a string, also with setopt()
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // curl_exec() executes the started curl session
        // $output contains the output string
        $comicData = curl_exec($curl);

        // close curl resource to free up system resources
        // (deletes the variable made by curl_init)
        curl_close($curl);

        // converting the json string to an array.
        // if(!empty($output)){
            $output = json_decode($comicData,true);
            // removing unnesscary characters from the transcirpt.
            $output['transcript'] = str_replace(array("}}","{","}","{{","]]","[[","(",")","'...'","...","alt"),"",$output['transcript']);
            return $output;
        // }
        // else{
            // if comic at $comic_id is null.
            // $comic_id = rand(0,2600);
            // getComic($comic_id);
        // }
        
        // echo '<pre>';
        // print_r( $output);
        // echo '</pre>';
        // echo '<a href="'.$output['img'].'" target="_blank">Image</a>';
        // $output['transcript'] = $transcript;
        // echo "<br>";
        // echo $output['transcript'];
        // print_r( $output);
        // echo "<br>";
        // echo $transcript;
        // print_r(explode(",", $output));
        // $lines = explode(",",$output);
        // $lines = str_replace(":","=>",$output);
        // print_r($lines);
        // echo '<br>';
        // $key = explode(":",$lines[0]);
        // $value = explode(":",$lines[1]);
        // echo '<br>';
        // echo $lines[9];
        // echo '<br>';
        // echo '<br>';
        // $result = array_combine($key,$value);
        // foreach($lines as $key => $val){
        //     echo "$key = $val<br>";
        // }
    }


?>