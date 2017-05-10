<?php
class Smtpmail {

public function server_parse($socket, $response, $line = __LINE__) { // Служебная функции отправки сообщений для парсинга сервера
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
	   
public function smtpmail($to='', $mail_to, $subject, $message, $headers='') { // Отправка письма через SMTP
	$SEND =	"Date: ".date("D, d M Y H:i:s") . " UT\r\n";
	$SEND .= 'Subject: =?'.SMTP_CHARSET.'?B?'.base64_encode($subject)."=?=\r\n";
	if ($headers) $SEND .= $headers."\r\n\r\n";
	else
	{
			$SEND .= "Reply-To: ".SMTP_USERNAME."\r\n";
			$SEND .= "To: \"=?".SMTP_CHARSET."?B?".base64_encode($to)."=?=\" <{$mail_to}>\r\n";
			$SEND .= "MIME-Version: 1.0\r\n";
			$SEND .= "Content-Type: text/html; charset=\"".SMTP_CHARSET."\"\r\n";
			$SEND .= "Content-Transfer-Encoding: 8bit\r\n";
			$SEND .= "From: \"=?".SMTP_CHARSET."?B?".base64_encode(BOT_NAME)."=?=\" <".SMTP_USERNAME.">\r\n";
			$SEND .= "X-Priority: 3\r\n\r\n";
	}
	$SEND .=  $message."\r\n";
	 if( !$socket = fsockopen(SMTP_HOST, SMTP_PORT, $errno, $errstr, 30) ) {
		 $result= "Ошибка:{$errno}\n{$errstr}";
		return $result;
	 }
  
	if (!Func::server_parse($socket, "220", __LINE__)) return $result;
 
	fputs($socket, "HELO " . SMTP_HOST . "\r\n");
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
	fputs($socket, base64_encode(SMTP_USERNAME) . "\r\n");
	if (!Func::server_parse($socket, "334", __LINE__)) {
		 $result= 'Логин авторизации не был принят сервером!';
		fclose($socket);
		return $result;
	}
	fputs($socket, base64_encode(SMTP_PASSWORD) . "\r\n");
	if (!Func::server_parse($socket, "235", __LINE__)) {
		 $result= 'Пароль не был принят сервером как верный! Ошибка авторизации!';
		fclose($socket);
		return $result;
	}
	fputs($socket, "MAIL FROM: <".SMTP_USERNAME.">\r\n");
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


}
?>