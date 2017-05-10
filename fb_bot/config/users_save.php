<center><h1> Отчет по добавлению / изменению информации </h1><table border="1" cellspacing="0" cellpadding="5" width="70%">
<?
require_once("../../class/db.class.php");
include ("../config.php");
db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
foreach ($_POST[users_group] as $key => $value) 

{
$bd="UPDATE users SET users_group='{$value}' WHERE id='{$key}'";
echo $bd;
$result = mysql_query ($bd);
if ($result == 'true') {echo "Информация в базе обновлена успешно!";}
else {echo "<font color='red'>Информация в базе не обновлена!</font>";}
echo('<br>');
}
?>
<br><br>
<? header('Location: options.php?save=1')?>
