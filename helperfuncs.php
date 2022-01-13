<?php

    function Url(){
        if(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
            $protocol = 'https';
        }
        else{
            $protocol = 'http';
        }

        if(!isset($_SERVER['HTTP_HOST'])){
            if(!isset($_SERVER['PORT'])){
              $url = 'http://localhost/chirag/rtcamp_assignment';
            }
        }
        else{
            $url = $protocol.'://'.$_SERVER['HTTP_HOST'];
        }
        // $url = 'http://localhost/chirag/rtcamp_assignment';
        return $url;
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
    }


?>