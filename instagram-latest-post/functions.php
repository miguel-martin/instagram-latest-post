<?php

if(is_file(__DIR__.'/config.php')){
    include __DIR__.'/config.php';
}
else {
    die("Customize config.sample.php and save it as config.php");
}


function request($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    $request = curl_exec($curl);
    curl_close($curl);
    $request = json_decode($request, true);
    return $request;
}

function refreshToken(){
    global $token;
    global $site;

    $url = "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=$token";
    
    date_default_timezone_set("America/Panama");
    $date = date("Y-m-d H:i:s");
    $jsonPath = __DIR__ .'/update.json';
    $date_json = request($jsonPath)["update"];

    
    if(strtotime($date) - strtotime($date_json) > 86400){
        request($url);
        $array = array('update' => $date);
        $fp = fopen($jsonPath, 'w');
        fwrite($fp, json_encode($array, JSON_PRETTY_PRINT));
        fclose($fp);
    }
}

function instagramFeed(){
    global $token;
    $url = "https://graph.instagram.com/me/media?fields=username,permalink,timestamp,caption,id,media_type,media_url&access_token=$token";
    return request($url)["data"];
}

function getLastImage(){
    $feed = instagramFeed();
    foreach ($feed as $post){ // get the last uploaded post that is an image...
        if ($post['media_type'] == 'IMAGE'){
            return $post;
        }
    }
}

function renderLastImage(){
    $data = getLastImage();
    return sprintf('<a class="ig-post--link" href="%s">
                        <img class="ig-post--img" src="%s" alt="%s" />
                        <span class="ig-post--txt">%s</span>
                    </a>',$data['permalink'], $data['media_url'], $data['caption'], $data['caption']);
}

?>