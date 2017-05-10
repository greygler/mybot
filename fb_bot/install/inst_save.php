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
<h1>Сохраняем данные:  </h1>
<center>
<p align="left" style="width: 850px;">
<?

$fp = fopen('../config.php', 'w+');
flock($fp, LOCK_EX); // Блокирование файла для записи
$file_conf="Configuration for {$_POST['bot_name'][0]}: ";
$last_edit="Last edition by ".date('d.m.Y, h:i:s');
$create="Created by {$_POST['bot_name'][0]}";
$power1="Powered by Igor Sayutin";
$power2="http://it-senior.pp.ua";
$text="<?\n/* ".str_repeat("* ", 22)."\n";
$text.=" * ".str_pad($file_conf, 41, " ", STR_PAD_BOTH)." *\n";
$text.=" * ".str_pad($_SERVER['SERVER_NAME'], 41, " ", STR_PAD_BOTH)." *\n";
$text.=" * ".str_pad($last_edit, 41, " ", STR_PAD_BOTH)." *\n";
$text.=" ".str_repeat("* ", 22)."*/\n\n";


 foreach($_POST as $key => $value) {
	
 $s="define('". mb_strtoupper($key)."', '{$value[0]}'); 	// {$value[1]}\n";
 if ($key=='name_server')  {
	 $s.="define('HTTP_SERVER', 'http://{$value[0]}/'); 	// Доменное имя бота с http\n";
	 $s.="define('HTTPS_SERVER', 'https://{$value[0]}/');	// Доменное имя бота с https\n";
	
	 }
	$text.=$s; 
 echo ("<strong>{$value[1]}</strong>: {$value[0]}<br>");
}


$footer.="\n/* ".str_repeat("* ", 22)."\n";
$footer.=" * ".str_pad($create, 41, " ", STR_PAD_BOTH)." *\n";
$footer.=" * ".str_pad($power1, 41, " ", STR_PAD_BOTH)." *\n";
$footer.=" * ".str_pad($power2, 41, " ", STR_PAD_BOTH)." *\n";
$footer.=" ".str_repeat("* ", 22)."*/\n\n";
$text.="{$footer}?>\n";

fwrite($fp, $text);

flock($fp, LOCK_UN); // Снятие блокировки

fclose($fp);

include ("create_db.php");


?>
</p></center>
<form class="form" action="install.php">
<input class="save" type="submit" value="&#10004; Далее >>>"></p><br>

  </form>
 <font color="red"><strong>Теперь подтвердите WebHook в панели разработчика и жми кнопку ДАЛЕЕ >>> </strong></font>