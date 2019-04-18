<?php
define('BOT_TOKEN','705031786:AAECFCQWstgmfiey8SgaIQyz400dnXKfdMc');
define('API_TELEGRAM','https://api.telegram.org/bot'.BOT_TOKEN.'/');


function Debug($msg) {
    $myFile = "log.txt";
    $updateArray = print_r($msg, TRUE);
    $fh = fopen($myFile, 'a') or die("can't open file");
    fwrite($fh, $updateArray . "\n\n");
    fclose($fh);
  }

function SendToURL($address,$POST,$Response = TRUE){
    $ch = curl_init( );
    curl_setopt( $ch, CURLOPT_URL, $address );
    curl_setopt( $ch, CURLOPT_POST, TRUE );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $POST );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, $Response );
    $result = curl_exec( $ch );
    curl_close($ch);
    return $result;
}

function sendChatAction($chat_id,$action){
    $address = API_TELEGRAM."sendChatAction";
    $post = "chat_id=$chat_id&action=$action";
    return SendToURL($address,$post);
}

function sendMessage($chat_id, $text){
    sendChatAction($chat_id,"typing");
    $address = API_TELEGRAM."sendMessage";
    $post = "chat_id=$chat_id&text=$text";
    return SendToURL($address,$post);
}

function editMessageText($text, $chat_id=NULL, $message_id=NULL, $reply_markup = NULL, $inline_message_id = NULL, $parse_mode = NULL, $disable_web_page_preview = NULL){
	$address = API_TELEGRAM."editMessageText";
	$post = "text=$text";
	if(isset($chat_id))
		$post .= "&chat_id=$chat_id";
	if(isset($reply_markup))
		$post .="&reply_markup=$reply_markup";
	if(isset($inline_message_id))
		$post .="&inline_message_id=$inline_message_id";
	if(isset($message_id))
		$post .="&message_id=$message_id";
	if(isset($disable_web_page_preview))
		$post .="&disable_web_page_preview=$disable_web_page_preview";
	if(isset($parse_mode))
		$post .="&parse_mode=$parse_mode";
	return SendToURL($address,$post);
}


$update = json_decode(file_get_contents('php://input'));
$message_id = isset($update) ? $update->message->message_id : "";
$chat_id = isset($update) ? $update->message->chat->id : "";

sendMessage($chat_id, "⚠️لطفا صبر کنید ربات در حال جستجو می باشد⚠️");
sleep(1);
editMessageText("⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️",$chat_id, $message_id+1);
sleep(1);
editMessageText("⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️",$chat_id, $message_id+1);
sleep(1);
editMessageText("⬛️⬛️⬜️⬜️⬜️⬜️⬜️⬜️",$chat_id, $message_id+1);
sleep(1);
editMessageText("⬛️⬛️⬛️⬜️⬜️⬜️⬜️⬜️",$chat_id, $message_id+1);
sleep(1);
editMessageText("⬛️⬛️⬛️⬛️⬜️⬜️⬜️⬜️",$chat_id, $message_id+1);
sleep(1);
editMessageText("⬛️⬛️⬛️⬛️⬛️⬜️⬜️⬜️",$chat_id, $message_id+1);
sleep(1);
editMessageText("⬛️⬛️⬛️⬛️⬛️⬛️⬜️⬜️",$chat_id, $message_id+1);
sleep(1);
editMessageText("⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️",$chat_id, $message_id+1);
sleep(1);
editMessageText("⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️",$chat_id, $message_id+1);

?>