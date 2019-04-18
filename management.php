<?php


if ($chat_id == $admins[0]) {
  if($message_text == "مدیریت"){
    sendMessage($admins[0], "یک گزینه را انتخاب کنید:", ReplyKeyboardMarkup(array(array('افزودن دوره', ''), array('بازگشت به منوی اصلی'))));
  }
  if($message_text == "افزودن دوره"){
    sendMessage($admins[0], "رشته رو انتخاب کن.", ReplyKeyboardMarkup($Fields));
    Query("UPDATE state SET management='1' WHERE chat_id='$chat_id'");
  }
  if($State[1]['management'] == 1){
    $id_group = Query("SELECT id FROM groups WHERE name=N'$message_text'");
    $id_group = $id_group[1]['id'];
    Query("INSERT INTO course (name, id_group, price, master, time, day, link) VALUES (NULL, '$id_group', NULL, NULL, NULL, NULL, NULL)");
    Query("SELECT id FROM course WHERE ");
    sendMessage($admins[0], "اسم دوره چی باشه؟", ReplyKeyboardMarkup());
    Query("UPDATE state SET management='2' WHERE chat_id='$chat_id'");
  }
  if($State[1]['management'] == 2){
    sendMessage($admins[0], "اوکی تموم شد.", ReplyKeyboardMarkup());
  }
}
?>
