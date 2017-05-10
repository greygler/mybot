<? 
header("Content-type: text/html; charset=utf-8");
require_once("config.php");
require_once("text.php");
require_once("../class_fb/send.class.php");
require_once("../class_fb/func.class.php");
require_once("../class_common/db.class.php");	
require_once("../class_common/smtpmail.class.php");
require_once ("case.php");
$result=array();

if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe' && $_REQUEST['hub_verify_token'] == VERIFY_TOKEN)
{
     // Webhook setup request
    echo $_REQUEST['hub_challenge'];
} else {
	
// Открываем файл для логов	
$f = fopen("textfile.json", "a");
fwrite($f, date("H:i:s")."\n");
// end Открываем файл для логов	

$json = file_get_contents('php://input'); 
$jdata=json_decode($json, true);

fwrite($f, "json=".$json."\n"); // Лог json

if 	($jdata['object']=="page") // Действие - сообщение с мессенджера

{



foreach ($jdata['entry'] as $entry)
{
	$entry_id=$entry['id'];
	$entry_time=$entry['time'];
	
	foreach ($entry['messaging'] as $messaging) {
		// Сохраняем переменные из сообщения
		$user_id=$messaging['sender']['id']; // USER_ID
		$recipient_id=$messaging['recipient']['id']; // PAGE_ID
		$text_mess=$messaging['message']['text']; // Сообщение;
		$mid=$messaging['message']['mid']; // ID сообщения
		$sticker_id=$messaging['message']['sticker_id']; // Пользователь прислал стикер
		$timestamp= $messaging['timestamp']; // Время
		$is_echo=$messaging['message']['is_echo']; // Это эхо
		$delivery_seq=$messaging['delivery']['seq']; // Доставлено
		$delivery=$messaging['delivery']['watermark']; // Watermark доставки
		$read_seq=$messaging['read']['seq']; // Прочитано
		$read=$messaging['read']['watermark']; // Watermark Прочтения
		$postback=$messaging['postback']['payload']; // postback
		$quick_reply=$messaging['message']['quick_reply']['payload']; // Быстрый ответ
		if ($user_id!="") { $about=Func::user_id($user_id); // Запрашиваем данные о пользователе
										// Использование
										//$about['first_name'] - Имя
										//$about['last_name'] - Фамилия
										//$about['profile_pic'] - Фото профиля
										//$about['users_pic'] - Имя файла, сохраненного фото профиля
										//$about['locale'] - Локаль (язык) пользователя на Facebook
										//$about['timezone'] - Часовой пояс — число, связанное с GMT
										//$about['gender'] - Пол
										//$about['is_payment_enabled'] - Указывает, сможет ли пользователь получать сообщения об оплате от платформы Messenger
										//$about['db'] - Если $about['db']='ok' - данные взяты из базы
										 fwrite($f, "Прошли About...\n");
	if (($about['db']!='ok') AND ($about['first_name']!='')) {
		if ($text_mess!="") $text2="Первое сообщение пользователя «{$about['first_name']} {$about['last_name']}»: «{$text_mess}»"; else $text2="Пользователь «{$about['first_name']} {$about['last_name']}» присоединился по кнопке: «{$postback}»";
		$result[]=send::notification($about, "Служебное уведомление.\nК боту подключился новый пользователь",$text2);
		}
	}
									
									
	  
	  
	  $command = "";
// Получено сообщение от пользователя, записываем как команду
if ($quick_reply!="") { $command = $quick_reply; }  else
if ($text_mess!="") {$command = $text_mess; } 
    // ИЛИ Зафиксирован переход по кнопке, записываем как команду
 else if ($postback!="") { $command = $postback; } 
      else if ($sticker_id!="") {$command="sticker ".$sticker_id;}
 
 if ($command!="") {
	 $last_message=Func::last_message($user_id); // Забираем последнeе сообщение
	 $result[]=Func::log($user_id, $recipient_id, $entry_time, $timestamp, $mid, $command );// Сохраняем логи в базу
    }
/*  if (stristr($command, " ")) { $commands=stristr ($command, " ", true); $options=trim(stristr ($command, " ")); $command=$commands; } 
 $command = mb_strtoupper($command, 'UTF-8');
 $options = mb_strtoupper($options, 'UTF-8'); */
	$co=Func::command_and_options($command); // Разбиваем команду на комманду и опции

	  
	  // Сохраняем рабочие логи
	  fwrite($f, "entry_id=".$entry_id."\n");
	  fwrite($f, "entry_time=".$entry_time."\n");
	  fwrite($f, "user_id=".$user_id."\n");
	  fwrite($f, "recipient_id=".$recipient_id."\n");
	  fwrite($f, "text_mess=".$text_mess."\n");
	  fwrite($f, "mid=".$mid."\n");
	  fwrite($f, "entry_id=".$entry_id."\n");
	  fwrite($f, "timestamp=".$timestamp."\n");
	  fwrite($f, "is_echo=".$is_echo."\n");
	  fwrite($f, "delivery=".$delivery."\n");
	  fwrite($f, "read=".$read."\n");
	  fwrite($f, "delivery_seq=".$delivery_seq."\n");
	  fwrite($f, "sticker_id=".$sticker_id."\n");
	  fwrite($f, "read_seq=".$read_seq."\n");
	  fwrite($f, "postback=".$postback."\n");
	  fwrite($f, "quick_reply=".$quick_reply."\n");
	  fwrite($f, "command=".$co['command']."\n");
	  
	  // end Сохраняем логи
	  
	  
	
		if (($is_echo=="") and ($read=="") and ($delivery=="") and ($co['command']!="")) {
			
			// Если это не техническая информация и сообщение не пустое
			 $result = array_merge($result, Bot_case::bot_case_func($co['command'],  $co['options'], $text_mess, $user_id, $about, $entry_id, $last_message));
				// Вызываем функцию реакции на сообщение, получаем массив ответов	
			
			}
	
						
			
			else 
				if ($is_echo ) { // Это эхо
				
					fwrite($f, "Эхо - ок\n"); // Сохраянем лог result
			
				} else
					
				if ($delivery!="") { // Сообщение доставлено
				    $result=Func::log_delivery($delivery);
					fwrite($f, "Сообщение доставлено, {$result} \n"); // Сохраянем лог result
			
				} else	
				
				if ($read!="" ) { // Это эхо
				    $result=Func::log_read($read);
					fwrite($f, "Сообщение прочитано, {$result} \n"); // Сохраянем лог result
			
				} 	

	}
}
}
else // Действие - плагин
{
	$sender_id=$jdata['sender']['id']; // USER_ID
	$recipient_id=$jdata['recipient']['id']; // PAGE_ID
	$timestamp=$jdata['timestamp']; // Время
	$optin_ref=$jdata['optin"']['ref']; // Параметр data-ref, который определяет точка входа
	  // Сохраняем логи
	 fwrite($f, "sender_id=".$sender_id."\n");
	 fwrite($f, "recipient_id=".$recipient_id."\n");
	 fwrite($f, "timestamp=".$timestamp."\n");
	 fwrite($f, "optin_ref=".$optin_ref."\n");
	 // end Сохраняем логи
}

	foreach ($result as $key => $value)  fwrite($f, "result[{$key}] = {$value}\n"); // Сохраянем лог result
	fwrite($f, "=====================\n\n");
fclose($f); 
}