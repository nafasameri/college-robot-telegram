<?php
include_once('function.php');

$admins = array('92838553', '116245039');

$update = json_decode(file_get_contents('php://input'));
$message_id = isset($update) ? $update->message->id : "";
$chat_id = isset($update) ? $update->message->chat->id : "";
$message_text = isset($update) ? $update->message->text : "";
$from_id = isset($update) ? $update->message->from->id : "";
$from_first_name = isset($update) ? $update->message->from->first_name : "";
$from_last_name = isset($update) ? $update->message->from->last_name : "";
$from_username = isset($update) ? $update->message->from->username : "";
$callback_query_chat_id = isset($update->callback_query) ? $update->callback_query->message->chat->id : "";
$callback_query_message_id = isset($update->callback_query) ? $update->callback_query->message->message_id : "";
$callback_data = isset($update->callback_query) ? $update->callback_query->data : "";
$callback_query_id = isset($update->callback_query) ? $update->callback_query->message->message_id : "";


// State
try {SQL_Query("INSERT INTO tblMainState (chat_id, state) VALUES (."$chat_id.", 0)");}
catch (Exception $e) {$MainState = MYSQL_fetch_all(SQL_Query("SELECT state FROM tblMainState WHERE chat_id=."$chat_id));}
try {SQL_Query("INSERT INTO tblStateRegister (chat_id, state) VALUES (".$chat_id.", 0)");}
catch (Exception $e) {$RegisterState = MYSQL_fetch_all(SQL_Query("SELECT state FROM tblStateRegister WHERE chat_id=."$chat_id));}
try {SQL_Query("INSERT INTO tblStateCourse (chat_id, state) VALUES (".$chat_id.", 0)");}
catch (Exception $e) {$CourseState = MYSQL_fetch_all(SQL_Query("SELECT state FROM tblStateCourse WHERE chat_id=."$chat_id));}
try {SQL_Query("INSERT INTO tblStateGroup (chat_id, state) VALUES (".$chat_id.", 0)");}
catch (Exception $e) {$GroupState = MYSQL_fetch_all(SQL_Query("SELECT state FROM tblStateGroup WHERE chat_id=."$chat_id));}


// Keyboard
$MainKeyboard = array(array('اخبار'), array('گروه های آموزشی'), array('گالری تصاویر'), array('نظرسنجی', 'انتقادات و پیشنهادات')); // group:1 gallery:2 offer:3 nazarsanji:4
$Fields = array(array('مهندسی کامپیوتر', 'مهندسی برق'), array('مهندسی عمران', 'مهندسی مکانیک'), array('مهندسی انرژی', 'مهندسی شیمی'), array('مهندسی صنایع', 'ریاضیات و کاربردها'), array('بازگشت به منو اصلی'));
$Period = array(
	array(array('text'=>"توضیحات صوتی مدرس", 'callback_data'=>"voice")),
	array(array('text'=>"ثبت نام", 'callback_data'=>"register")),
	array(array('text'=>"شرایط تخفیفی", 'callback_data'=>"discount")),
	array(array('text'=>"بازگشت", 'callback_data'=>"back"))
);
$industry = array(array('کارشناس اکسل', 'تربیت کارشناس مدیریت پروژه'), array('بازگشت'));
$mechanic = array(array('ABAQUS', 'Solidworks'), array('FLUENT', 'کارشناس تاسیسات ساختمانی'), array('بازگشت'));

// MAIN PAGES
if($message_text == "/start")
  sendMessage($chat_id, "سلام\nربات کالج دانشگاه صنعتی قوچان هستم، از آشنای با شما بسیار خرسندم.\nاینجام تا به شما در مورد دوره های آموزشی کالج دانشگاه صنعتی قوچان کمک کنم! خوشحال می شوم بتوانم این کار را به خوبی برایتان انجام بدهم.\n\nدر چه موردی می توانم راهنماییتان کنم؟", ReplyKeyboardMarkup($MainKeyboard));
if($message_text == "بازگشت به منو اصلی")
	sendMessage($chat_id, "لطفا یک گزینه را انتخاب کنید.", ReplyKeyboardMarkup($MainKeyboard));
if($message_text == "گروه های آموزشی" || ($message_text == "بازگشت" && ($GroupState['state'] <= 8 && $GroupState['state'] >= 1))) {
  sendMessage($chat_id, "برای اطلاع از جزئیات دوره ها گرایش دوره موردنظر خود را انتخاب نمایید:", ReplyKeyboardMarkup($Fields));
	SQL_Query("UPDATE tblMainState SET state=1 WHERE chat_id=$chat_id");
}
if($message_text == "گالری تصاویر")
  sendMessage($chat_id, "در حال حاضر این دکمه غیرفعال می باشد.", ReplyKeyboardMarkup(array(array('دوره های برگزار شده'), array('بازگشت به منو اصلی'))));
if($message_text == "انتقادات و پیشنهادات"){
  sendMessage($chat_id, "لطفا هر انتقاد و پیشنهادی دارید برای ما ارسال کنید.", ReplyKeyboardMarkup(array(array('بازگشت به منو اصلی'))));
	SQL_Query("UPDATE tblMainState SET state=3 WHERE chat_id=$chat_id");
}
if($message_text == "نظرسنجی")
  sendMessage($chat_id, "در حال حاضر این دکمه غیرفعال می باشد.", ReplyKeyboardMarkup(array(array('بازگشت به منو اصلی'))));
if($message_text == "اخبار"){
	for($i = 1;1 <= 2; $i = $i + 1){
		$news = mysqli_fetch_all(SQL_Query("SELECT title, expaln FROM tblnews WHERE id=$i"));
		sendMessage($chat_id, $news['title']."\n\n".$news['explan'], ReplyKeyboardMarkup(array(array('بازگشت به منو اصلی'))));
	}
}

// FIELDS
if($message_text == "مهندسی کامپیوتر"){
  sendMessage($chat_id, "درحال حاضر هیچ دوره ای برای گروه آموزشی شما برگزار نشده است :(", ReplyKeyboardMarkup(array(array('بازگشت'))));
	SQL_Query("UPDATE tblStateGroup SET state=1 WHERE chat_id=$chat_id");
}
else if($message_text == "ریاضیات و کاربردها"){
  sendMessage($chat_id, "درحال حاضر هیچ دوره ای برای گروه آموزشی شما برگزار نشده است :(", ReplyKeyboardMarkup(array(array('بازگشت'))));
	SQL_Query("UPDATE tblStateGroup SET state=2 WHERE chat_id=$chat_id");
}
else if($message_text == "مهندسی صنایع" || ($message_text == "بازگشت" && ($CourseState['state'] == 1 || $CourseState['state'] == 5))){
  sendMessage($chat_id, "دوره ی مدنظر خود را انتخاب نمایید.", ReplyKeyboardMarkup($industry));
	SQL_Query("UPDATE tblStateGroup SET state=3 WHERE chat_id=$chat_id");
}
else if($message_text == "مهندسی عمران"){
  sendMessage($chat_id, "درحال حاضر هیچ دوره ای برای گروه آموزشی شما برگزار نشده است :(", ReplyKeyboardMarkup(array(array('بازگشت'))));
	SQL_Query("UPDATE tblStateGroup SET state=4 WHERE chat_id=$chat_id");
}
else if($message_text == "مهندسی مکانیک" || ($message_text == "بازگشت" && ($CourseState['state'] == 2 || $CourseState['state'] == 3 || $CourseState['state'] == 4 || $CourseState['state'] == 6))) {
  sendMessage($chat_id, "دوره ی مدنظر خود را انتخاب نمایید.", ReplyKeyboardMarkup($mechanic));
	SQL_Query("UPDATE tblStateGroup SET state=5 WHERE chat_id=$chat_id");
}
else if($message_text == "مهندسی انرژی"){
  sendMessage($chat_id, "درحال حاضر هیچ دوره ای برای گروه آموزشی شما برگزار نشده است :(", ReplyKeyboardMarkup(array(array('بازگشت'))));
	SQL_Query("UPDATE tblStateGroup SET state=6 WHERE chat_id=$chat_id");
}
else if($message_text == "مهندسی شیمی"){
  sendMessage($chat_id, "درحال حاضر هیچ دوره ای برای گروه آموزشی شما برگزار نشده است :(", ReplyKeyboardMarkup(array(array('بازگشت'))));
	SQL_Query("UPDATE tblStateGroup SET state=7 WHERE chat_id=$chat_id");
}
else if($message_text == "مهندسی برق"){
  sendMessage($chat_id, "درحال حاض-ر هیچ دوره ای برای گروه آموزشی شما برگزار نشده است :(", ReplyKeyboardMarkup(array(array('بازگشت'))));
	SQL_Query("UPDATE tblStateGroup SET state=8 WHERE chat_id=$chat_id");
}


// PERIOD
switch ($message_text) {
	case 'کارشناس اکسل':
		sendMessage($chat_id, "<a href='http://college.qiet.ac.ir/'>سرفصل و اطلاعات دوره...</a>", InlineKeyboardMarkup($Period), NULL, 'html');
		SQL_Query("UPDATE tblStateCourse SET state=1 WHERE chat_id=$chat_id");
		break;
	case 'ABAQUS':
		sendMessage($chat_id, "<a href='http://college.qiet.ac.ir/'>سرفصل و اطلاعات دوره...</a>", InlineKeyboardMarkup($Period), NULL, 'html');
		SQL_Query("UPDATE tblStateCourse SET state=2 WHERE chat_id=$chat_id");
		break;
	case 'Solidworks':
		sendMessage($chat_id, "<a href='http://college.qiet.ac.ir/'>سرفصل و اطلاعات دوره...</a>", InlineKeyboardMarkup($Period), NULL, 'html');
		SQL_Query("UPDATE tblStateCourse SET state=3 WHERE chat_id=$chat_id");
		break;
	case 'FLUENT':
		sendMessage($chat_id, "<a href='http://college.qiet.ac.ir/'>سرفصل و اطلاعات دوره...</a>", InlineKeyboardMarkup($Period), NULL, 'html');
		SQL_Query("UPDATE tblStateCourse SET state=4 WHERE chat_id=$chat_id");
		break;
	case 'MATLAB':
		sendMessage($chat_id, "<a href='http://college.qiet.ac.ir/'>سرفصل و اطلاعات دوره...</a>", InlineKeyboardMarkup($Period), NULL, 'html');
		SQL_Query("UPDATE tblStateCourse SET state=7 WHERE chat_id=$chat_id");
		break;
	case 'تربیت کارشناس مدیریت پروژه':
		sendMessage($chat_id, "<a href='http://college.qiet.ac.ir/'>سرفصل و اطلاعات دوره...</a>", InlineKeyboardMarkup($Period), NULL, 'html');
		SQL_Query("UPDATE tblStateCourse SET state=5 WHERE chat_id=$chat_id");
		break;
	case 'کارشناس تاسیسات ساختمانی':
		sendMessage($chat_id, "<a href='http://college.qiet.ac.ir/'>سرفصل و اطلاعات دوره...</a>", InlineKeyboardMarkup($Period), NULL, 'html');
		SQL_Query("UPDATE tblStateCourse SET state=6 WHERE chat_id=$chat_id");
		break;
}

if($callback_data == "register"){
	// sendMessage($callback_query_chat_id, "");//explain
	try{
		SQL_Query("INSERT INTO tblUser (chat_id, name, family, phone, email) VALUES ($chat_id, NULL, NULL, NULL, NULL)");
		SQL_Query("UPDATE tblStateRegister SET state=1 WHERE chat_id=$chat_id");
		sendMessage($callback_query_chat_id, "نام خود را وارد کنید:", ReplyKeyboardMarkup(array(array("بازگشت"))));
	}
	catch(Exception $e){
		// $code = mysqli_fetch_all(SQL_Query("SELECT code FROM tblUser WHERE chat_id=$chat_id"));
		$name = mysqli_fetch_all(SQL_Query("SELECT name FROM tblUser WHERE chat_id=$chat_id"));
		$family = mysqli_fetch_all(SQL_Query("SELECT family FROM tblUser WHERE chat_id=$chat_id"));
		$phone = mysqli_fetch_all(SQL_Query("SELECT phone FROM tblUser WHERE chat_id=$chat_id"));
		$email = mysqli_fetch_all(SQL_Query("SELECT email FROM tblUser WHERE chat_id=$chat_id"));
		sendMessage($callback_query_chat_id, "شما درگذشته با اطلاعات زیر ثبت نام نموده اید. آیا مایلید که تغییراتی در آنها ب وجود آورید؟\n\nنام : ".$name['name']."\nنام خانوادگی : ".$family['family']."\nشماره تماس : ".$phone['phone']."\nایمیل : ".$email['email'], InlineKeyboardMarkup(array(array(array('text'=>"آره", 'callback_data'=>"yes"), array('text'=>"نه", 'callback_data'=>"no")))));
	}
}
else if($callback_data == "voice"){
	// sendVoice($callback_query_chat_id, "", "", ReplyKeyboardMarkup(array(array("بازگشت"))));
}
else if($callback_data == "discount"){
	sendMessage($callback_query_chat_id, "غیر فعال", ReplyKeyboardMarkup(array(array("بازگشت"))));
}
else if($callback_data == "back"){
	switch ($CourseState['state']) {
		case 2:
		case 3:
		case 4:
		case 6:
		sendMessage($chat_id, "دوره ی مدنظر خود را انتخاب نمایید.", ReplyKeyboardMarkup($mechanic));
			break;

		case 1:
		case 5:
		sendMessage($chat_id, "دوره ی مدنظر خود را انتخاب نمایید.", ReplyKeyboardMarkup($industry));
			break;
	}
}

if($callback_data == "yes"){
	SQL_Query("UPDATE tblStateRegister SET state=1 WHERE chat_id=$chat_id");
	sendMessage($callback_query_chat_id, "نام خود را وارد کنید:", ReplyKeyboardMarkup(array(array("بازگشت"))));
}
else if($callback_data == "no")
	SQL_Query("UPDATE tblStateRegister SET state=6 WHERE chat_id=$chat_id");

if($message_text != "" && $RegisterState['state'] == 1){
	SQL_Query("UPDATE tblUser SET name='$message_text' WHERE chat_id=$chat_id");
	sendMessage($chat_id, "نام خانوادگی خود را وارد کنید:", ReplyKeyboardMarkup(array(array("بازگشت"))));
	SQL_Query("UPDATE tblStateRegister SET state=3 WHERE chat_id=$chat_id");
}
// else if($message_text != "" && $RegisterState['state'] == 2){
// 	SQL_Query("UPDATE tblUser SET family='$message_text' WHERE chat_id=$chat_id");
// 	sendMessage($chat_id, "شماره دانشجویی خود را وارد نمایید:", ReplyKeyboardMarkup(array(array("بازگشت"))));
// 	SQL_Query("UPDATE tblStateRegister SET state=3 WHERE chat_id=$chat_id");
// }
else if($message_text != "" && $RegisterState['state'] == 3){
	// SQL_Query("UPDATE tblUser SET code='$message_text' WHERE chat_id=$chat_id");
	SQL_Query("UPDATE tblUser SET family='$message_text' WHERE chat_id=$chat_id");
	sendMessage($chat_id, "شماره تماس خود را وارد کنید:", ReplyKeyboardMarkup(array(array("بازگشت"))));
	SQL_Query("UPDATE tblStateRegister SET state=4 WHERE chat_id=$chat_id");
}
else if($message_text != "" && $RegisterState['state'] == 4){
	SQL_Query("UPDATE tblUser SET phone='$message_text' WHERE chat_id=$chat_id");
	sendMessage($chat_id, "ایمیل خود را وارد کنید:", ReplyKeyboardMarkup(array(array("بازگشت"))));
	SQL_Query("UPDATE tblStateRegister SET state=5 WHERE chat_id=$chat_id");
}
else if($message_text != "" && $RegisterState['state'] == 5){
	SQL_Query("UPDATE tblUser SET email='$message_text' WHERE chat_id=$chat_id");
	sendMessage($chat_id, "اطلاعات شما با موفقیت ثبت شد. :)", ReplyKeyboardMarkup(array(array("بازگشت"))));
	SQL_Query("UPDATE tblStateRegister SET state=6 WHERE chat_id=$chat_id");
}
else if($RegisterState['state'] == 6){
	SQL_Query("INSERT INTO tblRegister VALUES (".$chat_id.", ".$CourseState['state'].")");
	$course = mysqli_fetch_all(SQL_Query("SELECT name FROM tblCourse WHERE chat_id=".$chat_id));
	sendMessage($chat_id, "شما در درس ".$course['name']." پیش ثبت نام نموده اید.", NULL);
	// $code = mysqli_fetch_all(SQL_Query("SELECT code FROM tblUser WHERE chat_id=$chat_id"));
	$name = mysqli_fetch_all(SQL_Query("SELECT name FROM tblUser WHERE chat_id=".$chat_id));
	$family = mysqli_fetch_all(SQL_Query("SELECT family FROM tblUser WHERE chat_id=".$chat_id));
	$phone = mysqli_fetch_all(SQL_Query("SELECT phone FROM tblUser WHERE chat_id=".$chat_id));
	$email = mysqli_fetch_all(SQL_Query("SELECT email FROM tblUser WHERE chat_id=".$chat_id));
	foreach ($admins as $admin)
		sendMessage($admin, "یک دانشجو در درس ".$course['name']."با مشخصات زیر پیش ثبت نام کرده است.\n\nنام و نام خانوادگی : ".$name['name']." ".$family['family']."\nشماره تماس : ".$phone['phone']."\nایمیل : ".$email['email']);
}

// ADMINS
if($message_text != "" && $MainState['state'] == 3)//offer
	foreach($admins as $admin)
		sendMessage($admin, "اطلاعات جدیدی در دکمه انتقادات و پیشنهادات ثبت شده است.\n\nاطلاعات کاربر:\nusername: ".$from_username."\nfirst name: ".$from_first_name."\nlast name: ".$from_last_name."\n\nانتقادات و پیشنهادات: ".$message_text, NULL);
?>
