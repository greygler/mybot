<? include ("../config.php")?>
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
    
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/png">
    <link rel="stylesheet" media="screen" href="css/style.css" />
    <style>
	
.form{
width: 600px;
 margin: 100px auto auto auto;
}

	</style>

  </head>
  <body>
  <center>
  <h1>Конфигуратор для Бота "<?= BOT_NAME ?>"</h1>
    <form class="form" action="autoring.php" method="POST">
  <fieldset>
    <legend><h2>Авторизуйтесь: </h2></legend>
   <label for="login">Login: <em>*</em></label><input required id="login" type="text" name="login">
    <label for="password">Password: <em>*</em></label><input required id="password" type="password" name="password">
    <label for="product">Быстрый переход: <em>*</em></label><select size="1" name="product">
		<option value="users">Пользователи</option>
	<option value="config">Конфигурация бота</option>
	<option value="password">Сменить пароль</option>
	</select>
	<? if ($_GET['pass']==1) echo ('<p><div class="nologin">ЛОГИН ИЛИ ПАРОЛЬ НЕ ВЕРНЫЙ!<br>Попробуйте еще раз.</div>');
       if ($_GET['pass']==2) echo ('<p><div class="nologin">Вы сменили пароль!<br>Авторизуйтесь снова.</div>');
	   if ($_GET['pass']==3) echo ('<p><div class="nologin">Смена пароля не возможна!<br>Вы ввели не правильный пароль!<br>Авторизуйтесь снова.</div>');
	   ?>	
	
  </fieldset>
<p><input type="submit" value="Авторизоваться"></p><br>
</form>
</center>
      </body>
</html>