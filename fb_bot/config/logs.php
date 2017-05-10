<head>
<link rel="stylesheet" media="screen" href="css/logs.css" /> 
</head>
<body style="width: 880px; margin: 0 auto">
<?
include ("../config.php");
require_once(ABS_DIR."class_common/db.class.php");
function whois($id)
{
$result = mysql_query("SELECT * FROM users where user_id={$id}");
$myrow = mysql_fetch_array($result);
$sender['name']="{$myrow['first_name']} {$myrow['last_name']}";
$sender['users_pic']=$myrow['users_pic'];
return $sender;	
}

db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
 //echo db::db_size();

$sender=whois($_GET['id']);


 $db="SELECT * FROM logs where user_id={$_GET['id']} or recipient_id={$_GET['id']}";
//echo "{$db}<br>";
 $result = mysql_query($db);
$myrow = mysql_fetch_array($result);
do 
{
	//echo('<table><tr><td>');
	
	if ($myrow['user_id']==$_GET['id']) 
	{
		$sender_name=$sender['name'];
		$title_log="Написал";
		$div='<div class="text1">';
		echo ('<div class="blok1"><table cellpadding="5"><tr><td>');
		$user_pic1='<img width="80" src="../'.DIR_USERS_PIC.$sender['users_pic'].'"></td><td> ';
		$user_pic2='';
	}
	else {
		$div='<div class="text2">';
		$title_log="Ответил";
		echo ('<div class="blok2"><table cellpadding="5"><tr><td>');
		$user_pic1='';
		$user_pic2='</td><td><img width="80" src="../'.DIR_USERS_PIC.BOT_LOGO.'"> ';
		if ($myrow['user_id']==BOT_ID) $sender_name=BOT_NAME; else $sender_name=whois($_GET['id']);
	    }
	echo ("{$user_pic1}<strong>{$sender_name} (ID:{$myrow['user_id']}), </strong> {$title_log}:");
	echo ("{$div}".nl2br($myrow['message'])."</div>{$user_pic2}");
	echo('</tr></td></table></div>');
}
while ($myrow = mysql_fetch_array($result));
?>