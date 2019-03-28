<?php

//api token bot
$botToken = "850248159:AAHTK-lDlr8ClCTAiP_eMnJGKjkgGRdcgnA";
$website = "https://bot-technews-telegram.herokuapp.com/".$botToken;

$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);

$chatId = $update["message"]["chat"]["id"];
$chatType = $update["message"]["chat"]["type"];

$message = $update["message"]["text"];

switch ($message) {
    case '/unga':
        $response = "Unguers, a la batalla sin miedo!!!";
        sendMessage($chatId, $response);
        break;
        case '/admin':
        $response = "@Jennicet_caudi, te necesitan aqui!!!";
        sendMessage($chatId, $response);
        break;
        case '/shadow':
        $response = "Comprueba si estas shadowbanned en twitter: shadownban.eu";
        sendMessage($chatId, $response);
        break;
        case '/leka':
        $response = "Parece que tienes complejo de LekaconK";
        sendMessage($chatId, $response);
        break;
        case '/cardigan':
        $response = "Borra tuits inapropiados: www.gocardigan.com";
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
