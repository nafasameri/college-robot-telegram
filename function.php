<?php
date_default_timezone_set("Asia/Tehran");
define('BOT_TOKEN','705031786:AAECFCQWstgmfiey8SgaIQyz400dnXKfdMc');
define('SQL_LOCATION','localhost');
define('DATABASE_NAME','db_college');
define('SQL_USER_NAEM','theme');
define('SQL_PASSWORD','');
define('API_TELEGRAM','https://api.telegram.org/bot'.BOT_TOKEN.'/');


function Query($query) {
  $conn = new mysqli(SQL_LOCATION, SQL_USER_NAEM, SQL_PASSWORD, DATABASE_NAME);
  if ($conn->connect_error)
      die("Connection failed: " . $conn->connect_error);
  $result = $conn->query($query);
  $conn->close();
  return $result;
}

function Fet($result) {
  $topel = array(array());
  if ($result->num_rows > 0)
    while($row = $result->fetch_assoc())
      $topel[] = $row;
  else
    return NULL;
  return $topel;
}

//Sql Connection
//sql Query run here for select utf8 Set and for time_zone Set Asia/Tehran
function SQL_Query($str){
  // $conn = new mysqli(DATABASE_NAME, SQL_USER_NAEM, SQL_PASSWORD);
  $database = mysqli_connect(SQL_LOCATION, SQL_USER_NAEM, SQL_PASSWORD ,DATABASE_NAME);
	mysqli_query($database,"SET NAMES utf8mb4");
	mysqli_query($database,"SET time_zone = '+00:00'");
	$ret = mysqli_query($database,$str);
	mysqli_close($database);
	return $ret;
}
//this function for send data to address
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
//Send sendChatAction
function sendChatAction($chat_id,$action){
    $address = API_TELEGRAM."sendChatAction";
    $post = "chat_id=$chat_id&action=$action";
    return SendToURL($address,$post);
}
//send message
function sendMessage($chat_id, $text, $reply_markup = NULL, $reply_to_message_id = NULL, $parse_mode = NULL,$disable_notification = NULL,$disable_web_page_preview = NULL){
    sendChatAction($chat_id,"typing");
    $address = API_TELEGRAM."sendMessage";
    $post = "chat_id=$chat_id&text=$text";
    if(isset($reply_markup))
        $post .="&reply_markup=$reply_markup";
    if(isset($reply_to_message_id))
        $post .="&reply_to_message_id=$reply_to_message_id";
    if(isset($disable_notification))
        $post .="&disable_notification=$disable_notification";
    if(isset($disable_web_page_preview))
        $post .="&disable_web_page_preview=$disable_web_page_preview";
    if(isset($parse_mode))
        $post .="&parse_mode=$parse_mode";
    return SendToURL($address,$post);
}
//send Sticker
function sendSticker($chat_id,$sticker,$reply_markup = NULL,$reply_to_message_id = NULL,$disable_notification = NULL){
    $address = API_TELEGRAM."sendSticker";
    $post = "chat_id=$chat_id&sticker=$sticker";
    if(isset($reply_markup))
        $post .="&reply_markup=$reply_markup";
    if(isset($reply_to_message_id))
        $post .="&reply_to_message_id=$reply_to_message_id";
    if(isset($disable_notification))
        $post .="&disable_notification=$disable_notification";
    if(isset($caption))
        $post .="&caption=$caption";
    return SendToURL($address,$post);
}
//send Photo
function sendPhoto($chat_id,$photo,$caption = NULL,$reply_markup = NULL,$reply_to_message_id = NULL,$disable_notification = NULL){
    $address = API_TELEGRAM."sendPhoto";
    $post = "chat_id=$chat_id&photo=$photo";
    if(isset($reply_markup))
        $post .="&reply_markup=$reply_markup";
    if(isset($reply_to_message_id))
        $post .="&reply_to_message_id=$reply_to_message_id";
    if(isset($disable_notification))
        $post .="&disable_notification=$disable_notification";
    if(isset($caption))
        $post .="&caption=$caption";
    return SendToURL($address,$post);
}
//send audio
function sendAudio($chat_id,$audio,$caption = NULL,$reply_markup = NULL,$reply_to_message_id = NULL,$disable_notification = NULL,$title = NULL,$performer = NULL ,$duration = NULL){
    $address = API_TELEGRAM."sendAudio";
    $post = "chat_id=$chat_id&audio=$audio";
    if(isset($reply_markup))
        $post .="&reply_markup=$reply_markup";
    if(isset($reply_to_message_id))
        $post .="&reply_to_message_id=$reply_to_message_id";
    if(isset($disable_notification))
        $post .="&disable_notification=$disable_notification";
    if(isset($caption))
        $post .="&caption=$caption";
    if(isset($duration))
        $post .="&duration=$duration";
    if(isset($title))
        $post .="&title=$title";
    if(isset($performer))
        $post .="&performer=$performer";
    return SendToURL($address,$post);
}
//send sendVoice
function sendVoice($chat_id, $voice, $caption = NULL, $reply_markup = NULL,$reply_to_message_id = NULL,$disable_notification = NULL,$duration = NULL){
    $address = API_TELEGRAM."sendVoice";
    $post = "chat_id=$chat_id&voice=$voice";
    if(isset($reply_markup))
        $post .="&reply_markup=$reply_markup";
    if(isset($reply_to_message_id))
        $post .="&reply_to_message_id=$reply_to_message_id";
    if(isset($disable_notification))
        $post .="&disable_notification=$disable_notification";
    if(isset($caption))
        $post .="&caption=$caption";
    if(isset($duration))
        $post .="&duration=$duration";
    if(isset($title))
        $post .="&title=$title";
    if(isset($performer))
        $post .="&performer=$performer";
    return SendToURL($address,$post);
}
//send sendVideo
function sendVideo($chat_id,$video,$caption = NULL,$reply_markup = NULL,$reply_to_message_id = NULL,$disable_notification = NULL,$width = NULL,$height = NULL ,$duration = NULL){
    $address = API_TELEGRAM."sendVideo";
    $post = "chat_id=$chat_id&video=$video";
    if(isset($reply_markup))
        $post .="&reply_markup=$reply_markup";
    if(isset($reply_to_message_id))
        $post .="&reply_to_message_id=$reply_to_message_id";
    if(isset($disable_notification))
        $post .="&disable_notification=$disable_notification";
    if(isset($caption))
        $post .="&caption=$caption";
    if(isset($duration))
        $post .="&duration=$duration";
    if(isset($width))
        $post .="&width=$width";
    if(isset($height))
        $post .="&height=$height";
    return SendToURL($address,$post);
}
//send sendDocument
function sendDocument($chat_id,$document,$caption = NULL,$reply_markup = NULL,$reply_to_message_id = NULL,$disable_notification = NULL){
    $address = API_TELEGRAM."sendDocument";
    $post = "chat_id=$chat_id&document=$document";
    if(isset($reply_markup))
        $post .="&reply_markup=$reply_markup";
    if(isset($reply_to_message_id))
        $post .="&reply_to_message_id=$reply_to_message_id";
    if(isset($disable_notification))
        $post .="&disable_notification=$disable_notification";
    if(isset($caption))
        $post .="&caption=$caption";
    return SendToURL($address,$post);
}
//forwardMessage
function forwardMessage($chat_id, $from_chat_id, $message_id, $disable_notification = NULL){
	$address = API_TELEGRAM."forwardMessage";
	$post = "chat_id=$chat_id&from_chat_id=$from_chat_id&message_id=$message_id";
	if(isset($disable_notification))
		$post .="&disable_notification=$disable_notification";
	return SendToURL($address,$post);
}
//ReplyKeyboardMarkup
function ReplyKeyboardMarkup($keyboard,$resize_keyboard = true,$one_time_keyboard = false,$selective = false){
	$keys = array('keyboard' => $keyboard,'resize_keyboard'=>$resize_keyboard,'one_time_keyboard'=>$one_time_keyboard,'selective'=>$selective);
	return json_encode($keys);
}
//ReplyKeyboardRemove
function ReplyKeyboardRemove($selective = false){
	return json_encode(array('remove_keyboard'=>true,'selective'=>$selective));
}
//InlineKeyboardMarkup
function InlineKeyboardMarkup($keyboard){
	return json_encode(array('inline_keyboard'=>$keyboard));
}
//answerCallbackQuery
function answerCallbackQuery($callback_query_id, $text = NULL, $show_alert = NULL, $url = NULL, $cache_time = NULL){
	$addres = API_TELEGRAM."answerCallbackQuery";
	$post = "callback_query_id=$callback_query_id";
	if(isset($text))
		$post .="&text=$text";
	if(isset($show_alert))
		$post .="&show_alert=$show_alert";
	if(isset($url))
		$post .="&url=$url";
	if(isset($cache_time))
		$post .="&cache_time=$cache_time";
	return SendToURL($addres,$post);
}
//editMessageText
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
//editMessageReplyMarkup
function editMessageReplyMarkup($chat_id, $message_id, $reply_markup, $inline_message_id = NULL){
	$address = API_TELEGRAM."editMessageReplyMarkup";
	$post = "&reply_markup=$reply_markup";
	if(isset($chat_id))
		$post .= "&chat_id=$chat_id";
	if(isset($inline_message_id))
		$post .="&inline_message_id=$inline_message_id";
	if(isset($message_id))
		$post .="&message_id=$message_id";
	return SendToURL($address,$post);
}
//edit captoin file
function editMessageCaption($chat_id,$message_id,$caption,$reply_markup = NULL,$inline_message_id = NULL){
	$address = API_TELEGRAM."editMessageCaption";
	$post = "chat_id=$chat_id&message_id=$message_id&caption=$caption";
	if(isset($reply_markup))
		$post .= "&reply_markup=$reply_markup";
	if(isset($inline_message_id))
		$post .="&inline_message_id=$inline_message_id";
	return SendToURL($address,$post);
}
//function for fetch all rows
function MYSQL_fetch_all ($result, $result_type = MYSQLI_BOTH){
	/*if (!is_resource($result) || get_resource_type($result) != 'mysql result')
	{
		trigger_error(__FUNCTION__ . '(): supplied argument is not a valid MySQL result resource', E_USER_WARNING);
		return false;
	}
	if (!in_array($result_type, array(MYSQL_ASSOC, MYSQL_BOTH, MYSQL_NUM), true))
	{
		trigger_error(__FUNCTION__ . '(): result type should be MYSQL_NUM, MYSQL_ASSOC, or MYSQL_BOTH', E_USER_WARNING);
		return false;
	}*/
	$rows = array();
	while ($row = mysqli_fetch_array($result, $result_type))
		$rows[] = $row;
	return $rows;
}
//answerInlineQuery
function answerInlineQuery($inline_query_id, $results, $cache_time =NULL, $is_personal =NULL, $next_offset =NULL, $switch_pm_text =NULL, $switch_pm_parameter =NULL){
	$address = API_TELEGRAM."answerInlineQuery";
	$post = "inline_query_id=$inline_query_id&results=$results";
	if(isset($cache_time))
		$post .= "&cache_time=$cache_time";
	if(isset($is_personal))
		$post .= "&is_personal=$is_personal";
	if(isset($next_offset))
		$post .= "&next_offset=$next_offset";
	if(isset($switch_pm_text))
		$post .= "&switch_pm_text=$switch_pm_text";
	if(isset($switch_pm_parameter))
		$post .= "&switch_pm_parameter=$switch_pm_parameter";
    return SendToURL($address,$post);
}
//InlineQueryResult
function InlineQueryResult($array){
	return json_encode(array($array));
}
//InlineQueryResultArticle
function InlineQueryResultArticle($id, $title, $input_message_content, $description = NULL, $reply_markup = NULL, $url = NULL, $hide_url = NULL, $thumb_url = NULL, $thumb_width = NULL, $thumb_height = NULL){
	$array['type'] = "article";
	$array['id'] = $id;
	$array['title'] = $title;
	$array['input_message_content'] = $input_message_content;
	if(isset($reply_markup))
		$array['reply_markup'] = $reply_markup;
	if(isset($url))
		$array['url'] = $url;
	if(isset($hide_url))
		$array['hide_url'] = $hide_url;
	if(isset($description))
		$array['description'] = $description;
	if(isset($thumb_url))
		$array['thumb_url'] = $thumb_url;
	if(isset($thumb_width))
		$array['thumb_width'] = $thumb_width;
	if(isset($thumb_height))
		$array['thumb_height'] = $thumb_height;
	return $array;
}
//InputTextMessageContent
function InputTextMessageContent($message_text, $parse_mode = NULL, $disable_web_page_preview = NULL){
	$array['message_text'] = $message_text;
	if(isset($parse_mode))
		$array['parse_mode'] = $parse_mode;
	if(isset($disable_web_page_preview))
		$array['disable_web_page_preview'] = $disable_web_page_preview;
	return $array;
}
//getChatMember
function getChatMember($chat_id, $user_id){
	$address = API_TELEGRAM."getChatMember";
	$post = "chat_id=$chat_id&user_id=$user_id";
	return SendToURL($address,$post);
}
//leaveChat
function leaveChat($chat_id){
	$address = API_TELEGRAM."leaveChat";
	$post = "chat_id=$chat_id";
	return SendToURL($address,$post);
}
//function for exchange Persian Number to English number
function Pnum2Enum($str,$mod='en',$mf='٫'){
	$num_a=array('0','1','2','3','4','5','6','7','8','9','.');
	$key_a=array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹',$mf);
	return($mod=='fa')?str_replace($num_a,$key_a,$str):str_replace($key_a,$num_a,$str);
}
//Delete Message
function DeleteMessage($chat_id,$message_id){
  $address = API_TELEGRAM."deleteMessage";
  $post = "chat_id=$chat_id&message_id=$message_id";
  return SendToURL($address,$post);
}
//getChat
function getChat($chat_id){
  $address = API_TELEGRAM."getChat";
  $post = "chat_id=$chat_id";
	return SendToURL($address,$post);
}
//get cout member
function getChatMembersCount($chat_id){
  $address = API_TELEGRAM."getChatMembersCount";
  $post = "chat_id=$chat_id";
	$result = json_decode(SendToURL($address,$post),true);
	if(array_key_exists("result",$result))
		return $result['result'];
	return 0;
}
//get group administrator
function getChatAdministrators($chat_id){
	$address = API_TELEGRAM."getChatAdministrators";
  $post = "chat_id=$chat_id";
  return SendToURL($address,$post);
}
//kick chat member
function kickChatMember($chat_id,$user_id,$until_date = NULL){
	$address = API_TELEGRAM."kickChatMember";
	$post = "chat_id=$chat_id&user_id=$user_id";
	if(isset($until_date))
		$post .= "&until_date=$until_date";
    return SendToURL($address,$post);
}
//send unknown type message
function sendUnknownMessage($type, $chat_id, $text = NULL, $filePath = NULL ,$reply_markup = NULL,$reply_to_message_id = NULL,$parse_mode = NULL,$disable_notification = NULL){
	switch ($type){
		case "message":
			sendMessage($chat_id, $text,$reply_markup,$reply_to_message_id,$parse_mode,$disable_notification);
			break;
		case "sticker":
			sendSticker($chat_id, $filePath,$reply_markup,$reply_to_message_id,$disable_notification);
			break;
		case "photo":
			sendPhoto($chat_id, $filePath,$text,$reply_markup,$reply_to_message_id,$disable_notification);
			break;
		case "audio":
			sendAudio($chat_id, $filePath,$text,$reply_markup,$reply_to_message_id,$disable_notification);
			break;
		case "voice":
			sendVoice($chat_id, $filePath,$text,$reply_markup,$reply_to_message_id,$disable_notification);
			break;
		case "video":
			sendVideo($chat_id, $filePath,$text,$reply_markup,$reply_to_message_id,$disable_notification);
			break;
		case "document":
			sendDocument($chat_id, $filePath,$text,$reply_markup,$reply_to_message_id,$disable_notification);
			break;
	}
}
?>
