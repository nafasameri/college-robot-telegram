<?php
include_once('functions.php');

$admins = array('92838553', '116245039');
$update = json_decode(file_get_contents('php://input'));
$message_id = isset($update) ? $update->message->message_id : "";
$chat_id = isset($update) ? $update->message->chat->id : "";
$message_text = isset($update) ? $update->message->text : "";
$from_first_name = isset($update) ? $update->message->from->first_name : "";
$from_last_name = isset($update) ? $update->message->from->last_name : "";
$from_username = isset($update) ? $update->message->from->username : "";
$callback_query_chat_id = isset($update->callback_query) ? $update->callback_query->message->chat->id : "";
$callback_query_message_id = isset($update->callback_query) ? $update->callback_query->message->message_id : "";
$callback_data = isset($update->callback_query) ? $update->callback_query->data : "";
$phone_number = isset($update->message->contact) ? $update->message->contact->phone_number : $message_text;

// Keyboard
if($chat_id == $admins[0] || $chat_id == $admins[1])
  $MainKeyboard = array(array('گروه های آموزشی'), array('گالری تصاویر', 'اخبار'), array('نظرسنجی', 'انتقادات و پیشنهادات'), array('پشتیبان گیری'));
else
  $MainKeyboard = array(array('گروه های آموزشی'), array('گالری تصاویر', 'اخبار'), array('نظرسنجی', 'انتقادات و پیشنهادات'));
$Fields = array(array('مهندسی کامپیوتر', 'مهندسی برق'), array('مهندسی صنایع', 'مهندسی مکانیک'), array('مهندسی انرژی', 'مهندسی شیمی'), array('مهندسی عمران', 'ریاضیات و کاربردها'), array('عمومی', 'زبان'), array('بازگشت به منو اصلی'));

// State
if(isset($update->callback_query)) {
  //try {Query("INSERT INTO state (chat_id, registerstate) VALUES ('$callback_query_chat_id','0')");} catch (Exception $e) {}
  $State = Fetch(Query("SELECT * FROM state WHERE chat_id='$callback_query_chat_id'")); }
else {
  try {Query("INSERT INTO state (chat_id, mainstate, groupstate, coursestate, registerstate, management) VALUES ('$chat_id','0','0','0','0','0')");} catch (Exception $e) {}
  $State = Fetch(Query("SELECT * FROM state WHERE chat_id='$chat_id'"));
}

//MAIN
switch ($message_text) {
	case "/start":
		sendMessage($chat_id, "سلام\nربات کالج دانشگاه صنعتی قوچان هستم، از آشنای با شما بسیار خرسندم.\nاینجام تا به شما در مورد دوره های آموزشی کالج دانشگاه صنعتی قوچان کمک کنم! خوشحال می شوم بتوانم این کار را به خوبی برایتان انجام بدهم.\n\nدر چه موردی می توانم راهنماییتان کنم؟", ReplyKeyboardMarkup($MainKeyboard));
    Query("UPDATE state SET mainstate='0', groupstate='0', coursestate='0', registerstate='0',management='0' WHERE chat_id='$chat_id'");
    break;
	case "بازگشت به منو اصلی":
    sendMessage($chat_id, "لطفا یک گزینه را انتخاب کنید.", ReplyKeyboardMarkup($MainKeyboard));
    Query("UPDATE state SET mainstate='0', groupstate='0', coursestate='0', registerstate='0',management='0' WHERE chat_id='$chat_id'");
		break;
  case "گروه های آموزشی":
    sendMessage($chat_id, "برای اطلاع از جزئیات دوره ها گرایش دوره موردنظر خود را انتخاب نمایید:", ReplyKeyboardMarkup($Fields));
    Query("UPDATE state SET mainstate='1' WHERE chat_id='$chat_id'");
    break;
  case "گالری تصاویر":
    sendMessage($chat_id, "در حال حاضر این دکمه غیرفعال می باشد.", ReplyKeyboardMarkup(array(array('دوره های برگزار شده'), array('بازگشت به منو اصلی'))));
    break;
  case "دوره های برگزار شده":
    sendMessage($chat_id, "در حال حاضر این دکمه غیرفعال می باشد.", ReplyKeyboardMarkup(array(array('بازگشت به منو اصلی'))));
    break;
  case "انتقادات و پیشنهادات":
    sendMessage($chat_id, "لطفا هر انتقاد و پیشنهادی دارید برای ما ارسال کنید.", ReplyKeyboardMarkup(array(array('بازگشت به منو اصلی'))));
    Query("UPDATE state SET mainstate='3' WHERE chat_id='$chat_id'");
    break;
  case "نظرسنجی":
    $curs = ExtractCourses(Fetch(Query("SELECT course.name FROM course JOIN register ON course.id = register.id_course WHERE id_user='$chat_id'")));
    if($curs != NULL) {
      sendMessage($chat_id, "شما در دوره های زیر ثبت نام نموده اید. هر دوره ای که مدنظرتان است را انتخاب نموده نظرتان را درباره ی آن بیان کنید.", ReplyKeyboardMarkup($curs));
      Query("UPDATE state SET mainstate='4' WHERE chat_id='$chat_id'");    
    }
    else
      sendMessage($chat_id, "شما در هیچ دوره ای ثبت نام نکرده اید. این بخش مخصوص کسانی است که حداقل در یک دوره حضور داشته باشند.");
    break;
  case "اخبار":
    $news = Fetch(Query("SELECT title, link FROM news WHERE id='1'"));
    $link = $news[1]['link'];
    $title = $news[1]['title'];
    sendMessage($chat_id, $title, InlineKeyboardMarkup(array(array(array('text'=>"ورود به سایت", 'url'=>"$link")))));
    
    $news = Fetch(Query("SELECT title, expaln, link FROM news WHERE id='2'"));
    $link = $news[1]['link'];
    $title = $news[1]['title'];
    sendMessage($chat_id, $title, InlineKeyboardMarkup(array(array(array('text'=>"ورود به سایت", 'url'=>"$link")))));
    break;
  case "بازگشت":
    if($State[1]['registerstate'] >= 1) {
      $id_course = $State[1]['coursestate'];
      $id_group = Fetch(Query("SELECT id_group FROM course WHERE id = '$id_course'"));
      $id_group = $id_group[1]['id_group'];
      $courses = Fetch(Query("SELECT name FROM course WHERE id_group = '$id_group'"));
      $Courses = ExtractCourses($courses);
      sendMessage($chat_id ,"دوره ی مدنظر خود را انتخاب نمایید." ,ReplyKeyboardMarkup($Courses));
      Query("UPDATE state SET groupstate='$id_group', registerstate='0', coursestate='0', management='0' WHERE chat_id='$chat_id'");
    }
    else if($State[1]['mainstate'] == 4 || $State[1]['mainstate'] == 41 ||$State[1]['mainstate'] == 42 || $State[1]['mainstate'] == 0) {
      sendMessage($chat_id, "لطفا یک گزینه را انتخاب کنید.", ReplyKeyboardMarkup($MainKeyboard));
      Query("UPDATE state SET mainstate='0', groupstate='0', coursestate='0', registerstate='0',management='0' WHERE chat_id='$chat_id'");
    }
    else {
      sendMessage($chat_id, "برای اطلاع از جزئیات دوره ها گرایش دوره موردنظر خود را انتخاب نمایید:", ReplyKeyboardMarkup($Fields));
      Query("UPDATE state SET mainstate='1', groupstate='0', coursestate='0', registerstate='0', management='0' WHERE chat_id='$chat_id'");
    }
    break;
  case "پشتیبان گیری":  
    if ($chat_id == $admins[0] || $chat_id == $admins[1]) {
      sendMessage($chat_id, "<a href='https://bs-design.ir/BotQiet/ExportExcellRegister.php'>دانلود فایل اکسل</a>", NULL, NULL, 'html');
      // SendToURL(ExportExell(Query("SELECT user.name, family, phone, course.name FROM register JOIN user ON register.id_user=user.chat_id JOIN course ON register.id_course=course.id"), "register", "نام\tنام خوانوادگی\tشماره تماس\tنام دوره\t"), NULL);
    }
    break;
}

// PERIOD
if($State[1]['groupstate'] >= 1 && $message_text != "" && $message_text != "بازگشت" && $message_text != "بازگشت به منو اصلی") {
  $Course = Fetch(Query("SELECT id, name, price, master, time, day, link FROM course WHERE name= N'$message_text'"));
  $text = "نام دوره: ".$Course[1]['name']."\nقیمت: ".$Course[1]['price']."\nمدرس دوره: ".$Course[1]['master']."\nتاریخ شروع برگزاری: ".$Course[1]['time']."\nروزهای برگزاری: ".$Course[1]['day']."\n\n<a href='".$Course[1]['link']."'>سرفصل و اطلاعات دوره...</a>";
  if($Course == NULL) {
    $id_group = $State[1]['groupstate'];
    $courses = ExtractCourses(Fetch(Query("SELECT course.name FROM groups JOIN course ON groups.id = course.id_group WHERE groups.id = '$id_group'")));
    sendMessage($chat_id, "دوره مورد نظر شما درحال حاضر وجود ندارد.", ReplyKeyboardMarkup($courses));
  }
  else {
    $Period = array(array(array('text'=>"توضیحات صوتی مدرس", 'callback_data'=>"voice")), array(array('text'=>"ثبت نام", 'callback_data'=>"register")), array(array('text'=>"شرایط تخفیفی", 'callback_data'=>"discount")), array(array('text'=>"بازگشت", 'callback_data'=>"back")));
    if($State[1]['management'] == 0) {
      sendMessage($chat_id, $text, InlineKeyboardMarkup($Period), NULL, 'html');
      $message_id= $message_id +1;
      Query("UPDATE state SET management='$message_id' WHERE chat_id='$chat_id'");
    }
    else if($State[1]['management'] > 0)
      editMessageText($chat_id, $text, $State[1]['management'], InlineKeyboardMarkup($Period), 'html');
    $CourseId = $Course[1]['id'];
    Query("UPDATE state SET coursestate='$CourseId' WHERE chat_id='$chat_id'");
  }
}

switch($State[1]['mainstate']) {
  case 1: // FILEDS
    if ($message_text == "مهندسی کامپیوتر" || $message_text == "مهندسی برق" ||$message_text == "مهندسی عمران" ||$message_text == "مهندسی مکانیک" ||$message_text == "مهندسی صنایع" ||$message_text == "مهندسی شیمی" ||$message_text == "مهندسی انرژی" ||$message_text == "ریاضیات و کاربردها" || $message_text == "عمومی" || $message_text == "زبان") {
      $courses = Fetch(Query("SELECT course.name FROM groups JOIN course ON groups.id = course.id_group WHERE groups.name = N'$message_text'"));
      if($courses == NULL)
        sendMessage($chat_id, "درحال حاضر هیچ دوره ای برای گروه آموزشی شما برگزار نشده است :(", ReplyKeyboardMarkup($Fields));
      else {
        $Courses = ExtractCourses($courses);
        sendMessage($chat_id ,"دوره ی مدنظر خود را انتخاب نمایید." ,ReplyKeyboardMarkup($Courses, true, true));
        $id_group = Fetch(Query("SELECT id FROM groups WHERE name=N'$message_text'"));
        $id_group = $id_group[1]['id'];
        Query("UPDATE state SET groupstate='$id_group' WHERE chat_id='$chat_id'");
        Query("UPDATE state SET mainstate='0' WHERE chat_id='$chat_id'");
      }
    }
    break;
  case 2: // گالری تصاویر
    break;
  case 3: // offers
    if($message_text != "" && $message_text != "بازگشت به منو اصلی") {
      sendMessage($chat_id, "انتقادات و پیشنهادات شما با موفقیت برای ادمین ها ارسال شد.", ReplyKeyboardMarkup(array(array('بازگشت به منو اصلی'))));
      sendToAdmins($admins, "اطلاعات جدیدی در دکمه انتقادات و پیشنهادات ثبت شده است.\n\nاطلاعات کاربر:\nیوزرنیم: @".$from_username."\nنام: ".$from_first_name."\nنام خانوادگی: ".$from_last_name."\n\nانتقادات و پیشنهادات: ".$message_text);
      Query("UPDATE state SET mainstate='0' WHERE chat_id='$chat_id'");
    }
    break;
  case 4: // نظرسنجی
    $id_course = Fetch(Query("SELECT id FROM course WHERE name=N'$message_text'"));
    $id_course = $id_course[1]['id'];
    if (Fetch(Query("SELECT * FROM comments WHERE chat_id='$chat_id' AND course_id !='$id_course'")) == NULL)
    {
      Query("UPDATE state SET coursestate='$id_course' WHERE chat_id='$chat_id'");
      sendMessage($chat_id, "چند درصد از این دوره رضایت دارید؟", InlineKeyboardMarkup(
          array(
            array(array('text'=>"10", 'callback_data'=>"10"), array('text'=>"20", 'callback_data'=>"20"), array('text'=>"30", 'callback_data'=>"30")), 
            array(array('text'=>"40", 'callback_data'=>"40"), array('text'=>"50", 'callback_data'=>"50"), array('text'=>"60", 'callback_data'=>"60")), 
            array(array('text'=>"70", 'callback_data'=>"70"), array('text'=>"80", 'callback_data'=>"80"), array('text'=>"90", 'callback_data'=>"90")), 
            array(array('text'=>"100", 'callback_data'=>"100")) 
          )));
    }
    else
      sendMessage($chat_id, "شما نظرتان را درمورد این دوره ثبت کرده اید. نظرات ثبت شده قابل تغییر نیستند.");
    break;
  case 41:
    Query("UPDATE comments SET comment='$message_text' WHERE chat_id='$chat_id'");
    sendMessage($chat_id, "از شما سپاس گذاریم که وقتتان را در اختیارمان گذاشتید و نظرتان را ثبت کردید.");
    Query("UPDATE state SET mainstate='0' WHERE chat_id='$chat_id'");
    $id_course = $State[1]['coursestate'];
    $course = Fetch(Query("SELECT name FROM course WHERE id='$id_course'"));
    $information = Fetch(Query("SELECT * FROM comments WHERE chat_id='$chat_id' AND course_id='$id_course'"));
    sendToAdmins($admins, "یک دانشجو از درس ". $course[1]['name']. " ". $information[1]['satisfaction']. " درصد رضایت داشته است. و نظر کلی او راجب به این درس این گونه است:\n\"".$information[1]['comment']."\"");
    break;
}

switch ($callback_data) {
  case "register":
    Query("UPDATE state SET groupstate='0' WHERE chat_id='$callback_query_chat_id'");
  	sendMessage($callback_query_chat_id, "شما می توانید با پیش ثبت نام در این دوره از شرایط تخفیفی بهرمند شوید.");//explain
    $information = Fetch(Query("SELECT name, family, phone FROM user WHERE chat_id='$callback_query_chat_id'"));
    if($information[1]['phone'] == NULL) {
      Query("INSERT INTO user(chat_id, name, family, phone) VALUES ('$callback_query_chat_id',NULL,NULL,NULL)");
      Query("UPDATE state SET registerstate='1' WHERE chat_id='$callback_query_chat_id'");
  		sendMessage($callback_query_chat_id, "نام خود را وارد کنید:", ReplyKeyboardMarkup(array(array('بازگشت'))));
  	}
  	else
  		sendMessage($callback_query_chat_id, "شما درگذشته با اطلاعات زیر ثبت نام نموده اید. آیا مایلید که تغییراتی در آنها ب وجود آورید؟\n\nنام : ".$information[1]['name']."\nنام خانوادگی : ".$information[1]['family']."\nشماره تماس : ".$information[1]['phone'], InlineKeyboardMarkup(array(array(array('text'=>"آره", 'callback_data'=>"yes"), array('text'=>"نه", 'callback_data'=>"no")))));
    break;
  case "voice":
    Query("UPDATE state SET groupstate='0' WHERE chat_id='$callback_query_chat_id'");
    // sendVoice($callback_query_chat_id, "", "", ReplyKeyboardMarkup(array(array("بازگشت"))));
    sendMessage($callback_query_chat_id, "غیر فعال", ReplyKeyboardMarkup(array(array("بازگشت"))));
    break;
  case "discount":
    Query("UPDATE state SET groupstate='0' WHERE chat_id='$callback_query_chat_id'");    
    sendMessage($callback_query_chat_id, "غیر فعال", ReplyKeyboardMarkup(array(array("بازگشت"))));
    break;
  case "back":
    $coState = $State[1]['coursestate'];
    $id_group = Fetch(Query("SELECT id_group FROM course WHERE id = '$coState'"));
    $id_group = $id_group[1]['id'];
    $course = Fetch(Query("SELECT name FROM course WHERE id_group = '$id_group'"));
    $Courses = ExtractCourses($courses);
    sendMessage($callback_query_chat_id, "دوره ی مدنظر خود را انتخاب نمایید.", ReplyKeyboardMarkup($Courses));
    Query("UPDATE state SET groupstate='$id_group' WHERE chat_id='$callback_query_chat_id'");
    break;
  case "yes":
     Query("UPDATE state SET registerstate='1' WHERE chat_id='$callback_query_chat_id'");
	   sendMessage($callback_query_chat_id, "نام خود را وارد کنید:", ReplyKeyboardMarkup(array(array("بازگشت"))));
     break;
  case "no":
     sendMessage($callback_query_chat_id, "آیا ماییلید عملیات ثبت نام کامل شود؟", ReplyKeyboardMarkup(array(array('تایید عملیات ثبت نام'))));
     Query("UPDATE state SET registerstate='4' WHERE chat_id='$callback_query_chat_id'");
    break;
  case "10":
  case "20":
  case "30":
  case "40":
  case "50":
  case "60":
  case "70":
  case "80":
  case "90":
  case "100":
    $id_course = $State[1]['coursestate'];
    Query("INSERT INTO comments (chat_id, course_id, satisfaction) VALUES ('$callback_query_chat_id', '$id_course', '$callback_data')");
    sendMessage($callback_query_chat_id, "نظرتان را درباره این دوره تایپ کنید و برای ما ارسال نمایید.");
    Query("UPDATE state SET mainstate='41' WHERE chat_id='$callback_query_chat_id'");
    break;
}

switch ($State[1]['registerstate']) {
  case 1:
    if($message_text != "" && $message_text != "بازگشت") {
      Query("UPDATE user SET name='$message_text' WHERE chat_id='$chat_id'");
      sendMessage($chat_id, "نام خانوادگی خود را وارد کنید:", ReplyKeyboardMarkup(array(array("بازگشت"))));
      Query("UPDATE state SET registerstate='2' WHERE chat_id='$chat_id'");
    }
    break;
  case 2:
    if($message_text != "" && $message_text != "بازگشت") {
      Query("UPDATE user SET family='$message_text' WHERE chat_id='$chat_id'");
      sendMessage($chat_id, "شماره تماس خود را وارد کنید:", ReplyKeyboardMarkup(array(array(array('text'=>'شماره تماس', 'request_contact'=>true)) ,array("بازگشت"))));
      Query("UPDATE state SET registerstate='3' WHERE chat_id='$chat_id'");
    }
    break;
  case 3:
    if($phone_number != "" && $message_text != "بازگشت") {
      Query("UPDATE user SET phone='$phone_number' WHERE chat_id='$chat_id'");   
      Lodding($chat_id, "لطفا شکیبا باشید، سیستم در حال ثبت اطلاعات شماست.", $message_id+1, "اطلاعات شما با موفقیت ثبت شد. :)");
      Query("UPDATE state SET registerstate='4' WHERE chat_id='$chat_id'");
    }
  case 4:
    Query("UPDATE state SET registerstate='0' WHERE chat_id='$chat_id'");
    $id_Course = $State[1]['coursestate'];
    Query("INSERT INTO register (id_user, id_course) VALUES ('$chat_id', '$id_Course')");
  	$course = Fetch(Query("SELECT name FROM course WHERE id='$id_Course'"));
    sendMessage($chat_id, "شما در درس ". $course[1]['name'] . " پیش ثبت نام نموده اید.", ReplyKeyboardMarkup(array(array("بازگشت"))));
  	$information = Fetch(Query("SELECT name, family, phone FROM user WHERE chat_id='$chat_id'"));
    sendToAdmins($admins, "یک دانشجو در درس ".$course[1]['name']." با مشخصات زیر پیش ثبت نام کرده است.\n\nنام و نام خانوادگی : ".$information[1]['name']." ".$information[1]['family']."\nشماره تماس : ".$information[1]['phone']);
    break;
}
?>