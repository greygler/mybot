<? 
session_start();
include ("logins.php");
 include ("../config.php");
 //echo $_SESSION['product'];
if (($_SESSION['login']==$login) AND ($_SESSION['password'])==$password) { 
if ($_SESSION['product']!="") {$product=$_SESSION['product']; $_SESSION['product']="";}
else $product=$_GET['product'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="http://it-senior.pp.ua" />
    <meta name="copyright" content="Meridian Promotion Group" />
<title>Configuration for  <?= BOT_NAME ?></title>
    <meta name="keywords" content="Ключевые слова">
    <meta name="description" content="Описание">

<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/png">
     <link rel="stylesheet" media="screen" href="css/style.css" />  
    <style>
		
		.form{ width: <? if ($product=="password") echo "700px;\n"; else echo("90%;\n"); ?>  margin: <? if ($product=="password") echo "100px"; else echo("0"); ?> auto auto auto;}
		
	</style>

  </head>
  <body>
  <? if ($product!=='password') { ?>
  
  <ul class="menu">
	<li><a href="?product=users">Пользователи</a></li>
	<li><a href="#">Настройки</a>
		<ul>
			<li><a href="?product=password">Сменить пароль</a></li>
			<li><a href="#">123</a></li>
			<li><a href="#">234</a></li>
		</ul>
	</li>
	
	<li><a href="exit.php">Выход</a></li>
</ul>
  <br> <? } ?>

  
 <? $include=$product.".php";
 $save=$product."_save.php";
 
 switch ($product) {
					case "password":
						$th1="Настройки доступа для бота ";
					break;
					
					case "config":
						$th1="Конфигуратор бота ";
					break;
					
					case "add":
						$th1="Работа с товаром в базе бота ";
					break;
					case "users":
						$th1="Пользователи бота ";
					break;
 }
 
 ?>
  <h1><?= $th1." ".BOT_NAME ?></h1>

    <form class="form" action="<?= $save ?>" method="POST" enctype="multipart/form-data"> 
 <? if ($_GET['save']=='1') echo ('<div class="ok">Данные успешно сохранены!</div><br>');
include("{$include}") ?>
<p><input type="submit" value="Сохранить"></p><br>
</form> 

      </body>
</html>
<? }
else
header("Location: index.php?pass=1"); ?>