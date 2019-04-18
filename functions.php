<?php
date_default_timezone_set("Asia/Tehran");
define('BOT_TOKEN','705031786:AAECFCQWstgmfiey8SgaIQyz400dnXKfdMc');
define('API_TELEGRAM','https://api.telegram.org/bot'.BOT_TOKEN.'/');
define('SQL_LOCATION','localhost');

// college
// define('DATABASE_NAME','college_robot');
// define('SQL_USER_NAEM','college_ruser');
// define('SQL_PASSWORD','xSyDW1Bs');

// bs-design
define('DATABASE_NAME','bsdesign_collegeqiet');
define('SQL_USER_NAEM','bsdesign_ameri');
define('SQL_PASSWORD','ameriameriameri@');

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

function Query($query) {
  $conn = new mysqli(SQL_LOCATION, SQL_USER_NAEM, SQL_PASSWORD, DATABASE_NAME);
  if ($conn->connect_error)
      die("Connection failed: " . $conn->connect_error);
  mysqli_set_charset($conn,"utf8");
  $result = $conn->query($query);
  $conn->close();
  return $result;
}

function Fetch($result) {
  $topel = array(array());
  if ($result->num_rows > 0)
    while($row = $result->fetch_assoc())
      $topel[] = $row;
  else
    return NULL;
  return $topel;
}

function ExportExell($result, $filename, $head) {
  $set_data = '';
  while ($rec = mysqli_fetch_row($result)) {
      $row_data = '';
      foreach ($rec as $value) {
        $value = '"' . $value . '"'. "\t";
        $row_data .= $value;
      }
      $set_data .= trim($row_data). "\n";
  }

  header("Content-type: application/octet-stream");
  header("Content-Disposition: attachment; filename=".$filename.".xls");
  header('Content-Transfer-Encoding: binary');
  header("Pragma: no-cache");
  header("Expires: 0");

  echo chr(255).chr(254).iconv("UTF-8", "UTF-16LE//IGNRE", $head . "\n" . $set_data . "\n");
  exit();
}

function Debug($msg) {
  $myFile = "log.txt";
  $updateArray = print_r($msg, TRUE);
  $fh = fopen($myFile, 'a') or die("can't open file");
  fwrite($fh, $updateArray . "\n\n");
  fclose($fh);
}

function sendChatAction($chat_id,$action){
    $address = API_TELEGRAM."sendChatAction";
    $post = "chat_id=$chat_id&action=$action";
    return SendToURL($address,$post);
}

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

function sendDocument($chat_id, $document, $caption = NULL, $reply_markup = NULL, $reply_to_message_id = NULL, $disable_notification = NULL){
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

function ReplyKeyboardMarkup($keyboard,$resize_keyboard = true,$one_time_keyboard = false,$selective = false){
	$keys = array('keyboard' => $keyboard,'resize_keyboard'=>$resize_keyboard,'one_time_keyboard'=>$one_time_keyboard,'selective'=>$selective);
	return json_encode($keys);
}

function InlineKeyboardMarkup($keyboard){
	return json_encode(array('inline_keyboard'=>$keyboard));
}

function editMessageText($chat_id, $text, $message_id, $reply_markup = NULL, $parse_mode = NULL, $inline_message_id = NULL, $disable_web_page_preview = NULL){
	$address = API_TELEGRAM."editMessageText";
	$post = "text=$text&chat_id=$chat_id&message_id=$message_id";
	if(isset($reply_markup))
		$post .="&reply_markup=$reply_markup";
	if(isset($inline_message_id))
		$post .="&inline_message_id=$inline_message_id";
	if(isset($disable_web_page_preview))
		$post .="&disable_web_page_preview=$disable_web_page_preview";
	if(isset($parse_mode))
		$post .="&parse_mode=$parse_mode";
	return SendToURL($address,$post);
}

function ExtractCourses($courses) {
  for($i = 0;$i < count($courses); $i++)
    $Courses[$i][0] = $courses[$i+1]['name'];
  if($Courses[count($courses)-1][0] == NULL)
    $Courses[count($courses)-1][0] = 'بازگشت';
    return $Courses;
}

function sendToAdmins($admins, $msg, $reply_markup = NULL) {
  foreach($admins as $admin)
    sendMessage($admin, $msg, $reply_markup);
}

function Lodding($chat_id, $message, $message_id, $message_end) {
  sendMessage($chat_id, $message);
  sleep(1);
  editMessageText($chat_id, "⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️", $message_id);
  sleep(1);
  editMessageText($chat_id, "⬛️⬜️⬜️⬜️⬜️⬜️⬜️⬜️", $message_id);
  sleep(1);
  editMessageText($chat_id, "⬛️⬛️⬜️⬜️⬜️⬜️⬜️⬜️", $message_id);
  sleep(1);
  editMessageText($chat_id, "⬛️⬛️⬛️⬜️⬜️⬜️⬜️⬜️", $message_id);
  sleep(1);
  editMessageText($chat_id, "⬛️⬛️⬛️⬛️⬜️⬜️⬜️⬜️", $message_id);
  sleep(1);
  editMessageText($chat_id, "⬛️⬛️⬛️⬛️⬛️⬜️⬜️⬜️", $message_id);
  sleep(1);
  editMessageText($chat_id, "⬛️⬛️⬛️⬛️⬛️⬛️⬜️⬜️", $message_id);
  sleep(1);
  editMessageText($chat_id, "⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬜️", $message_id);
  sleep(1);
  editMessageText($chat_id, "⬛️⬛️⬛️⬛️⬛️⬛️⬛️⬛️", $message_id);
  sleep(1);
  editMessageText($chat_id, $message_end, $message_id);
}

?>