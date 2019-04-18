<?php
include_once('functions.php');


ExportExell(Query("SELECT user.name, family, phone, course.name FROM register JOIN user ON register.id_user=user.chat_id JOIN course ON register.id_course=course.id"), "register", "نام\tنام خوانوادگی\tشماره تماس\tنام دوره\t");  
?>