<?php

//api token bot
$botToken = "861290587:AAH4gVojqBE8P2Ni0MKuPPYCggCELo-hKH4";
$website = "https://api.telegram.org/bot".$botToken;

$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);

$chatId = $update["message"]["chat"]["id"];
$chatType = $update["message"]["chat"]["type"];

$message = $update["message"]["text"];

switch ($message) {
    case '/saludos':
        $response = "Sois unos mataos, pero de ven en cuando os haceis querer.";
        sendMessage($chatId, $response);
        break;
    case '/noticias':
        getNews($chatId);
        break;
}

function sendMessage($chatId, $message){
    $url = $GLOBALS[website].'/command?chat_id'.$chatId.'&parse_mode=HTML'.urlencode($response);
    file_get_contents($url);
}
function getNews($chatId){
    include("simple_html_dom.php");
    $context = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
    
    $url = "http://feeds.weblogssl.com/genbeta";
    $xmlstring = file_get_contents($url, false, $context);
    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    
    $array = json_decode($json, TRUE);
    for ($i=0; $i < 9 ; $i++) { 
        $titulos = $titulos."\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
        +info</a>";
    }
    
    sendMessage($chatId, $titulos);
}
?>
