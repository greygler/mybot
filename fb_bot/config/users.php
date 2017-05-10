<?
include ("../config.php");
require_once(ABS_DIR."class_common/db.class.php");
db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
 //echo db::db_size();
 
 $result = mysql_query("SELECT * FROM users_group");
$myrow = mysql_fetch_array($result);
do if ($myrow['id']!=10)
{
	$users_group[$myrow['id']]=$myrow['name'];
}
while ($myrow = mysql_fetch_array($result));	
 ?>
 <center>
 
 
<table border="0" cellspacing="0" cellpadding="5" width="100%">
    <tr bgcolor="darkgrey" >
    <!--    <td align="center">№</td> -->
		<td align="center">Аватар</td>
		<td align="center">Имя</td>
		<td align="center">Фамилия</td>
		<td align="center">USER_ID</td>
        <td align="center">Локализация</td>
        <td align="center">Временная<br>зона</td>
        <td align="center">Пол</td>
        <td align="center">Оплата</td>
        <td align="center">Время</td>
		 <td align="center">Команда</td>
         <td align="center">Группа</td>
    </tr>
	
	<?
	$i=1;
	
 $result = mysql_query("SELECT * FROM users");
$myrow = mysql_fetch_array($result);
do if ($myrow['first_name']!=BOT_NAME)
{
if ((($i%2)!=1) AND ($myrow['users_group']>0))  $bgcolor=' bgcolor="lightgrey" '; else $bgcolor='';	
if ($myrow['users_group']==0)  $bgcolor=' bgcolor="red" ';  	

echo '<tr '.$bgcolor.' align="center">';
//echo '<td align="center">'.$myrow['id'].'</td>';
echo '<td width="110" align="center"><a target="_blank" href="'.$myrow['profile_pic'].'"><img width="80" src="../'.DIR_USERS_PIC.$myrow['users_pic'].'"></a></td>'."\n";
echo '<td align="center">'.$myrow['first_name'].'</td>';
echo '<td align="center">'.$myrow['last_name'].'</td>';
echo '<td align="center">'.$myrow['user_id'].'</td>';
echo '<td align="center">'.$myrow['locale'].'</td>';
echo '<td align="center">'.$myrow['timezone'].'</td>';
echo '<td align="center">'.$myrow['gender'].'</td>';
echo '<td align="center">'.$myrow['is_payment_enabled'].'</td>';
echo '<td align="center"><a href="#id'.$myrow['user_id'].'">';
if ($myrow['last_time']>0) echo date("d.m.y H:i:s",$myrow['last_time']); else echo('Логи>>>');
echo '</a></td>';
echo '<td align="center"><a href="#id'.$myrow['user_id'].'">'.$myrow['last_message'].'</a></td>';
echo '<td align="center">';

echo '<select style="width: 120px" size="1" name="users_group['.$myrow['id'].']">';

foreach ($users_group as $key => $value)	{
echo '<option ';
if ($key==$myrow['users_group']) echo 'selected'; 
echo' value="'.$key.'">'.$value.'</option>'."\n";
}

echo '</select></td></tr>';
echo('<a href="#x" class="overlay" id="id'.$myrow['user_id'].'"></a>
        <div class="popup">
<h2>Логи <strong>'.$myrow['first_name'].' '.$myrow['last_name'].'</strong></h2>
<iframe src="logs.php?id='.$myrow['user_id'].'" width="910" height="600" >
    
 </iframe>
    
        <a class="close" title="Закрыть" href="#x"></a>
        </div>');
$i++;
}
while ($myrow = mysql_fetch_array($result));	
?>

</table><br>
	