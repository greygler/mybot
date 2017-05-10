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
.form{width: 850px; margin: 0 auto auto auto;}
.form input, textarea {width: 549px;}
.info {margin-left: 250px;}
</style>  
  </head>
  <body>
<h1>FaceBook ответ:  </h1>
<center>
<p align="left" style="width: 850px;">
<?
require_once("../config.php");
require_once(ABS_DIR."class_fb/func.class.php");
require_once(ABS_DIR."class_fb/options.class.php");
$json = file_get_contents(Func::LINK_FB.'/me/subscribed_apps?access_token='.TOKEN); 

//echo ($json);
$install=json_decode($json,true);
//foreach ($install['data'] as $key => $value) echo ("{$key} = {$value}<br>");
echo "<strong>Путь к приложению Бота:</strong> {$install['data'][0]['link']}<br>";
echo "<strong>Имя бота:</strong> {$install['data'][0]['name']}<br>";
echo "<strong>Тип бота:</strong> {$install['data'][0]['namespace']}<br>";
echo "<strong>ID бота:</strong> {$install['data'][0]['id']}<br>";
$json_wl= Options::white_listed(HTTPS_SERVER);
$wl=json_decode($json_wl,true);
if ($wl['result']=='success') $wl_result="успешно"; else $wl_result="с ошибкой((";
echo("<strong>Домен ".HTTPS_SERVER."</strong> добавлен в Белый список: {$wl_result}");   
?></p></center>
<form class="form" action="start_screen.php" method="POST">

<fieldset>
    <legend><h2>&#160;<i class="fa fa-info-circle"></i>&#160;Стартовый экран:&#160; </h2></legend>
	<label for="start">Команда для старта: <span></span> <em>*</em></label><input required id="start" type="text" name="start" value="HELLO" placeholder="Команда для старта"></p>
	<label for="start_text">Текст стартового экрана<span><br></span></label><textarea rows="5" id="start_text" name="start_text" cols="70"></textarea></p>
	
	<p><input class="save" type="submit" value="&#10004; Далее >>>"></p><br>
	<div class="info"> 
	<p align="left"><small>Приветсвующий текст не более 160 символов.<br>Для обращения к пользователю по имени допускаются переменные:</p>
	<div align="left">
	<ul>
	    
    
   

	<li>{{user_first_name}}	- имя</li>
	<li>{{user_last_name}}	- Фамилия</li>
	<li>{{user_full_name}}	- Полное имя</li>
	</ul></small>
	</div>
	</div>
  </fieldset>
  </form>