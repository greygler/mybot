<?
require_once(ABS_DIR."class_common/db.class.php");

class Func // Имя класса с большой буквы
{
	const LINK_FB='https://graph.facebook.com/v2.6/';


 public function user_id($id) // Запрос данных о пользователе, возвращаем массив
       {
		db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
		$result = mysql_query("SELECT * FROM users WHERE user_id='{$id}'");
		$myrow = mysql_fetch_array($result);
		if ($myrow['id']!="") {
			
			$users=array(
				"first_name" =>  $myrow['first_name'],
				"last_name" => $myrow['last_name'],
				"profile_pic" => $myrow['profile_pic'],
				"locale" => $myrow['locale'],
				"timezone" => $myrow['timezone'],
				"gender" => $myrow['gender'],
				"is_payment_enabled" => $myrow['is_payment_enabled'],
				"db" => 'ok'
			);
			
		}
		else {
			$json = file_get_contents(Func::LINK_FB.$id.'?fields=first_name,last_name,profile_pic,locale,timezone,gender,is_payment_enabled&access_token='.TOKEN);
			$users= json_decode($json, true);
			
			if ($users['first_name']!="") {
				$type_users_pic='.jpg';
				$users_pic_name=$id.$type_users_pic;
				$path = DIR_USERS_PIC.$users_pic_name;
				
				file_put_contents($path, file_get_contents($users['profile_pic']));
				$bd="INSERT INTO users (user_id, first_name, last_name, profile_pic, users_pic, locale, timezone, gender, is_payment_enabled, users_group) VALUES ('{$id}', '{$users[first_name]}', '{$users[last_name]}', '{$users[profile_pic]}','{$users_pic_name}', '{$users[locale]}','{$users[timezone]}','{$users[gender]}','{$users[is_payment_enabled]}','1')"; 
			}
			else 
				if ($id!="") {$bd="INSERT INTO users (user_id, first_name) VALUES ('{$id}', '".BOT_NAME."')";  }
				//if ($result == 'true') {echo "Информация добавлена успешно!";} else {echo "Информация не добавлена!";}
			$result = mysql_query ($bd);
			 }
		return $users;
       }	

public function server_parse($socket, $response, $line = __LINE__) {
	while (@substr($server_response, 3, 1) != ' ') {
		if (!($server_response = fgets($socket, 256))) {
		    echo "<p>Проблемы с отправкой почты!</p>$response<br>$line<br>";
 			return false;
 		}
	}
	if (!(substr($server_response, 0, 3) == $response)) {
		echo "<p>Проблемы с отправкой почты!</p>$response<br>$line<br>";
		return false;
	}
	return true;
}	   


public function command_and_options($command)
		{
			 if (stristr($command, " ")) { $commands=stristr ($command, " ", true); $options=trim(stristr ($command, " ")); $command=$commands; } 
			 $command_and_options['command'] = mb_strtoupper($command, 'UTF-8');
			 $command_and_options['options'] = mb_strtoupper($options, 'UTF-8');
			 return $command_and_options;
		}
	   
	   
public function smtpmail($to='', $mail_to, $subject, $message, $headers='', $config) {
	$SEND =	"Date: ".date("D, d M Y H:i:s") . " UT\r\n";
	$SEND .= 'Subject: =?'.$config['smtp_charset'].'?B?'.base64_encode($subject)."=?=\r\n";
	if ($headers) $SEND .= $headers."\r\n\r\n";
	else
	{
			$SEND .= "Reply-To: ".$config['smtp_username']."\r\n";
			$SEND .= "To: \"=?".$config['smtp_charset']."?B?".base64_encode($to)."=?=\" <{$mail_to}>\r\n";
			$SEND .= "MIME-Version: 1.0\r\n";
			$SEND .= "Content-Type: text/html; charset=\"".$config['smtp_charset']."\"\r\n";
			$SEND .= "Content-Transfer-Encoding: 8bit\r\n";
			$SEND .= "From: \"=?".$config['smtp_charset']."?B?".base64_encode($config['smtp_from'])."=?=\" <".$config['smtp_username'].">\r\n";
			$SEND .= "X-Priority: 3\r\n\r\n";
	}
	$SEND .=  $message."\r\n";
	 if( !$socket = fsockopen($config['smtp_host'], $config['smtp_port'], $errno, $errstr, 30) ) {
		 $result= "Ошибка:{$errno}\n{$errstr}";
		return $result;
	 }
  
	if (!Func::server_parse($socket, "220", __LINE__)) return $result;
 
	fputs($socket, "HELO " . $config['smtp_host'] . "\r\n");
	if (!Func::server_parse($socket, "250", __LINE__)) {
		 $result= 'Не могу отправить HELO!';
		fclose($socket);
		return $result;
	}
	fputs($socket, "AUTH LOGIN\r\n");
	if (!Func::server_parse($socket, "334", __LINE__)) {
		 $result= 'Не могу найти ответ на запрос авторизаци.';
		fclose($socket);
		return $result;
	}
	fputs($socket, base64_encode($config['smtp_username']) . "\r\n");
	if (!Func::server_parse($socket, "334", __LINE__)) {
		 $result= 'Логин авторизации не был принят сервером!';
		fclose($socket);
		return $result;
	}
	fputs($socket, base64_encode($config['smtp_password']) . "\r\n");
	if (!Func::server_parse($socket, "235", __LINE__)) {
		 $result= 'Пароль не был принят сервером как верный! Ошибка авторизации!';
		fclose($socket);
		return $result;
	}
	fputs($socket, "MAIL FROM: <".$config['smtp_username'].">\r\n");
	if (!Func::server_parse($socket, "250", __LINE__)) {
		 $result= 'Не могу отправить комманду MAIL FROM: ';
		fclose($socket);
		return $result;
	}
	fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");
 
	if (!Func::server_parse($socket, "250", __LINE__)) {
		 $result= 'Не могу отправить комманду RCPT TO: ';
		fclose($socket);
		return $result;
	}
	fputs($socket, "DATA\r\n");
 
	if (!Func::server_parse($socket, "354", __LINE__)) {
		 $result= 'Не могу отправить комманду DATA';
		fclose($socket);
		return $result;
	}
	fputs($socket, $SEND."\r\n.\r\n");
 
	if (!Func::server_parse($socket, "250", __LINE__)) {
		 $result= 'Не смог отправить тело письма. Письмо не было отправленно!';
		fclose($socket);
		return $result;
	}
	fputs($socket, "QUIT\r\n");
	fclose($socket);
	return "ok";
	//return $result;
}



	   

	   
public function send_mail($to='', $mail_to, $subject, $message, $headers='') // Отправка почты SMTP
	// 'Имя получателя', 'email-получателя@mail.ru', 'Тема письма', 'HTML или обычный текст письма'
	{
		$config['smtp_username'] = 'bot2b@my-bot.xyz';  //Смените на адрес своего почтового ящика.
		$config['smtp_port'] = '465'; // Порт работы.
		$config['smtp_host'] =  'ssl://mail.adm.tools';  //сервер для отправки почты
		$config['smtp_password'] = 'UpBa44xAB55v';  //Измените пароль
	
		$config['smtp_charset'] = 'utf-8';	//кодировка сообщений. (windows-1251 или utf-8, итд)
		$config['smtp_from'] = 'Bot2B'; //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"
		$return_mail=func::smtpmail($to='', $mail_to, $subject, $message, $headers='', $config);
		return $return_mail;
	}
		
	
public function func_replace($str, $user_id) // Замены в сообщении
		{
			$about=Func::user_id($user_id);
			$text = str_replace("%first_name%", $about['first_name'], $str);
			$text = str_replace("%last_name%", $about['last_name'], $text);
            $text = str_replace("%user_photo%", $about['profile_pic'], $text);
			return $text;
		}
		
public function last_message($user_id) // Последнее сообщение
		{
			db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
			$result = mysql_query("SELECT * FROM users WHERE user_id='{$user_id}'");
			$myrow = mysql_fetch_array($result);	
			return $myrow['last_message'];
		}
	
public function curl_send($data_send_json, $mp)
		{
		$ch = curl_init(Func::LINK_FB.'me/'.$mp.'?access_token='.TOKEN);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_send_json);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
				'HTTP/1.1 200 OK',
				'Content-Type: application/json',                                                                                
				'Content-Length: ' . strlen($data_send_json))                                                                       
		 );                                                                                                                   
		$result = curl_exec($ch);	
		return $result;
		}
		
		
 public function log($id, $recipient_id, $entry_time, $timestamp, $mid, $message) // Запись в общий лог
       {
		db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
		$bd="INSERT INTO logs (user_id, recipient_id, entry_time, timestamp, mid, message) VALUES ('{$id}', {$recipient_id},'{$entry_time}', '{$timestamp}', '{$mid}','{$message}')"; 
		$result = mysql_query ($bd);
		$bd="UPDATE users SET last_time='".time()."', last_message='{$message}' WHERE user_id='{$id}'";  
		$result = mysql_query ($bd);
		
			if ($result == 'true') {$result="Общие логи: Информация добавлена успешно!";} else {$result= "Общие логи: Информация не добавлена!";}
			 
		return $result;
       }	
		
public function log_read($watermark) // Запись в лог - отметка о прочтении
       {
		db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
		$bd="UPDATE logs SET readmark='1' WHERE timestamp='{$watermark}'"; 
		$result = mysql_query ($bd);
		
		if ($result == 'true') {$result="Логи, отметка о прочтении: Информация добавлена успешно!";} else {$result= " Логи, отметка о прочтении: Информация не добавлена!";}
			 
		return $result;
       }		
	   
public function log_delivery($watermark) // Запись в лог последнее время общения с ботом
       {
		db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
		$bd="UPDATE logs SET delivery='1' WHERE timestamp='{$watermark}'"; 
		$result = mysql_query ($bd);
		
			if ($result == 'true') {$result="Логи - последнее время общения с ботом: Информация добавлена успешно!";} else {$result= " Логи - последнее время общения с ботом: Информация не добавлена!";}
			 
		return $result;
       }
	   
public function log_revision($id, $count_revision) // Запись в лог - последнее время общения с ботом
       {
		db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
		$lt=time();
		$lt=$lt-$last_time;
		$bd="UPDATE users SET last_time='".time()."', count_revision='{$count_revision}' WHERE user_id='{$id}'"; 
		//echo "<br><br>! ".$bd;
		$result = mysql_query ($bd);
		
			if ($result == 'true') {$result="Пользовательские логи -последнее время общения с ботом: Информация добавлена успешно!";} else {$result= "Пользовательские логи-последнее время общения с ботом: Информация не добавлена!";}
			 
		return $result;
       }
		
}