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
.form{width: 850px; margin: auto auto auto;}
.form input, textarea {width: 549px;}
</style>  
  </head>
  <body>
<h1>Создаем стартовый экран:  </h1>
<center>
<p align="left" style="width: 850px;">
<?
require_once("../config.php");
require_once(ABS_DIR."class_fb/options.class.php");
$json=Options::Get_Started($_POST['start']);
//echo ("Ответ: {$json}<br>");
$gs=json_decode($json, true);


echo ("Стартовый экран по команде <strong>{$_POST['start']}</strong> - ");
if ($gs['result']=='success') echo ("успешно создано!"); else echo("cоздано c ошибкой <strong>{$gs['result']}</strong>" );
echo('<br><br>');
$json==Options::Setting_Greeting_Text($_POST['start_text']);
//echo ("Ответ: {$json}<br>");
$sgt=json_decode($json, true);
 
echo ("Текст приветствия  <strong>{$_POST['start_text']}</strong <br><br>");
if ($sgt['result']=='success') echo ("успешно создано!"); else echo("cоздано c ошибкой <strong>{$gs['result']}</strong>" );
?>
</p>



</center>
<form class="form" action="enjoy.php">
<input class="save" type="submit" value="&#10004; Далее >>>"></p><br>

  </form>
 <font color="red"><strong>Стартовый экран создан, зайдите в Ваш бот >>> </strong></font>
