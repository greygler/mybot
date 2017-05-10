<? require_once("../config.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Igor Sayutin" />
    <meta name="copyright" content="http://it-senior.pp.ua" />
    <title>Install for FaceBook BOT <?= $_SERVER['SERVER_NAME'] ?></title>
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">   
	<link href="style.css" rel="stylesheet">
 <style>
.form{width: 850px; margin: <? if ($_POST['product']=="password") echo "100px"; else echo("0"); ?> auto auto auto;}
.form input, textarea {width: 549px;}
</style>  
  </head>
  <body>
<?

$abs_dir_explode = explode("/", __DIR__);
$key = array_search('install', $abs_dir_explode);
$key_dir=$key-1; //$dir_abs="/";
for ($i=0; $i<$key_dir; $i++) $dir_abs.=$abs_dir_explode[$i]."/";

?>
 
  <h1>Инсталяция FB-бота на домене <br><strong><?= $_SERVER['SERVER_NAME'] ?></strong></h1>
 
    <form class="form" action="inst_save.php#webhook" enctype="multipart/form-data" method="POST">

<fieldset>
    <legend><h2>&#160;<i class="fa fa-info-circle"></i>&#160;Общие сведения:&#160; </h2></legend>
	<label for="bot_name">Имя бота: <span></span> <em>*</em></label><input required id="bot_name" type="text" name="bot_name[0]" value="<?= BOT_NAME; ?>" placeholder="Имя бота"></p>
	<input type="hidden" name="bot_name[1]" value="Имя бота">
	<label for="bot_logo">Логотип бота: <span></span> <em>*</em></label><input required id="bot_logo" type="file" accept="image" name="bot_logo[0]" placeholder="Логотип бота"> <? if (BOT_LOGO!="") echo('<img width="80" src="../'.DIR_USERS_PIC.BOT_LOGO.'">'); ?>	</p>
	<input type="hidden" name="bot_logo[1]" value="Логотип бота">
	 <label for="name_server">Основной домен: <span></span> <em>*</em></label><input required id="name_server" type="text" name="name_server[0]" value="<? if (NAME_SERVER!="") echo NAME_SERVER; else echo $_SERVER['SERVER_NAME']  ?>" placeholder="Доменное имя бота"></p>
	<input type="hidden" name="name_server[1]" value="Доменное имя бота">
	 <label for="bot_id">ID бота: </label><input id="bot_id" type="text" name="bot_id[0]" value="<?= BOT_ID ?>" placeholder="ID бота, см. документацию"></p>
	<input type="hidden" name="bot_id[1]" value="ID бота">
	
	
  </fieldset>
  
  <fieldset>
    <legend><h2>&#160;<i class="fa fa-link"></i>&#160;Расположения:&#160; </h2></legend>
	<p allign="center" style="color: red">Внимание! В случае изменений в этом разделе обязательно переименуйте соответсвующие папки бота!<br>Имена папок должны иметь слеш в конце. <i>Например</i> <strong>images/</strong>  </p>
	<label for="bot_file">Основной файла Бота: <em>*</em><br><span></span> </label><input required id="bot_file" type="text" name="bot_file[0]" value="<?= BOT_FILE; ?>" placeholder="Имя основного файла Бота"></p>
	<input type="hidden" name="bot_file[1]" value="Имя основного файла Бота">
	<label for="abs_dir">Абсолютный путь: <em>*</em><br><span>Абсолютный путь к каталогу сайта</span> </label><input required id="abs_dir" type="text" name="abs_dir[0]" value="<?if (ABS_DIR!="") echo ABS_DIR; else echo $dir_abs; ?>" placeholder="Абсолютный путь к каталогу сайта"></p>
	<input type="hidden" name="abs_dir[1]" value="Абсолютный путь к каталогу сайта">
	<label for="dir">Основная папка: <em>*</em><br><span>Имена папок со слеш на конце!</span> </label><input required id="dir" type="text" name="dir[0]" value="<? if (DIR!="") echo DIR; else echo $abs_dir_explode[$key_dir]."/";  ?>" placeholder="Основная папка бота"></p>
	<input type="hidden" name="dir[1]" value="Основная папка бота">
	
	 <label for="dir_file">Папка с файлами: <em>*</em><br><span>Имена папок со слеш на конце!</span> </label><input required id="dir_file" type="text" name="dir_file[0]" value="<?= DIR_FILE ?>" placeholder="Имя папки с файлами для отправки"></p>
	<input type="hidden" name="dir_file[1]" value="Имя папки с файлами для отправки">
	 <label for="dir_images">Папка с картиками: <em>*</em><br><span>Имена папок со слеш на конце!</span></label><input id="dir_images" type="text" name="dir_images[0]" value="<?=  DIR_IMAGES ?>" placeholder="Имя папки с рисунками для отправки"></p>
	 <input type="hidden" name="dir_images[1]" value="Имя папки с рисунками для отправки">
	  <label for="dir_video">Папка с видео: <em>*</em><br><span>Имена папок со слеш на конце!</span> </label><input required id="dir_video" type="text" name="dir_video[0]" value="<?= DIR_VIDEO  ?>" placeholder="Имя папки с видео-файлами (mpeg4) для отправки"></p>
	<input type="hidden" name="dir_video[1]" value="Имя папки с видео-файлами (mpeg4) для отправки">
	 <label for="dir_audio">Папка с аудио: <em>*</em><br><span>Имена папок со слеш на конце!</span> </label><input required id="dir_audio" type="text" name="dir_audio[0]" value="<?=  DIR_AUDIO ?>" placeholder="Имя папки с аудио-файлами (mp3) для отправки">
	 <input type="hidden" name="dir_audio[1]" value="Имя папки с аудио-файлами (mp3) для отправки">
	  <label for="dir_users_pic">Папка с аватарами: <em>*</em><br><span>Имена папок со слеш на конце!</span> </label><input required id="dir_users_pic" type="text" name="dir_users_pic[0]" value="<?= DIR_USERS_PIC  ?>" placeholder="Имя папки с аватарами пользователей"></p>
	 <input type="hidden" name="dir_users_pic[1]" value="Имя папки с аватарами пользователей">
		
  </fieldset>
  
  <fieldset>
    <legend><h2>&#160;<i class="fa fa-database"></i>&#160;Доступы:&#160; </h2></legend>
	<label for="verify_token">Токен WebHook: <span></span> <em>*</em></label><input required id="verify_token" type="text" name="verify_token[0]" value="<?= VERIFY_TOKEN; ?>" placeholder="Токен проверки WebHook - выбирается произвольно"></p>
	<input type="hidden" name="verify_token[1]" value="Токен проверки WebHook">
	<label for="token">Основной токен: <span></span> <em>*</em></label><input required id="token" type="text" name="token[0]" value="<?= TOKEN  ?>" placeholder="Маркер доступа к станице"></p>
	<input type="hidden" name="token[1]" value="Маркер доступа к станице">
	<label for="db_host">Сервер БД: <em>*</em></label><input required id="db_host" type="text" name="db_host[0]" value="<?=  DB_HOST ?>" placeholder="Адрес базы данных, может называться localhost"></p>
	 <input type="hidden" name="db_host[1]" value="Адрес базы данных, может называться localhost">
	<label for="db_name">Имя БД: <em>*</em></label><input required iddb_name" type="text" name="db_name[0]" value="<?=  DB_NAME ?>" placeholder="Название базы данных"></p>
	<input type="hidden" name="db_name[1]" value="Название базы данных">  
	<label for="db_login">Логин БД: <em>*</em></label><input required id="db_login" type="text" name="db_login[0]" value="<?=  DB_LOGIN ?>" placeholder="Логин базы данных"></p>
	<input type="hidden" name="db_login[1]" value="Логин базы данных">
	<label for="db_pass">Пароль БД: <em>*</em></label><input required id="db_pass" type="text" name="db_pass[0]" value="<?=  DB_PASS ?>" placeholder="Пароль базы данных"></p>
	<input type="hidden" name="db_pass[1]" value="Пароль базы данных">
	
	
  </fieldset>
  
  <fieldset>
    <legend><h2>&#160;<i class="fa fa-info-circle"></i>&#160;SMTP сервер:&#160; </h2></legend>
	<label for="smtp_username">Адрес почтового ящика: <span></span> </label><input id="smtp_username" type="text" name="smtp_username[0]" value="<?= SMTP_USERNAME; ?>" placeholder="Адрес почтового ящика"></p>
	<input type="hidden" name="smtp_username[1]" value="Адрес почтового ящика">
	
	 <label for="smtp_port">SMTP порт: <span></span> </label><input  id="smtp_port" type="text" name="smtp_port[0]" value="<?= SMTP_PORT  ?>" placeholder="SMTP порт"></p>
	<input type="hidden" name="smtp_port[1]" value="SMTP порт">
	 <label for="smtp_host">ID бота: </label><input id="smtp_host" type="text" name="smtp_host[0]" value="<?= SMTP_HOST ?>" placeholder="SMTP сервер для отправки почты, для SSL начинается с ssl:// "></p>
	<input type="hidden" name="smtp_host[1]" value="SMTP сервер для отправки почты">
	<label for="smtp_password">Пароль SMTP сервера: </label><input id="smtp_password" type="text" name="smtp_password[0]" value="<?=  SMTP_PASSWORD ?>" placeholder="Пароль SMTP сервера"></p>
	<input type="hidden" name="smtp_password[1]" value="Пароль SMTP сервера">
	<input type="hidden" name="smtp_charset[0]" value="<?= SMTP_CHARSET ?>">
	<input type="hidden" name="smtp_charset[1]" value="кодировка сообщений. (windows-1251 или utf-8, и т.д.)">
  </fieldset>
  
  
  
<p><input class="save" type="submit" value="&#10004; Далее >>>"></p><br>
</form>
<div style="font-size:10px; float: right;">&copy; Igor Saytuin, <a href="http://it-senior.pp.ua">http://it-senior.pp.ua</a> <?= date("Y") ?></div>
      </body>
</html>