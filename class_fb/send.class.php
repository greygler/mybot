<?
require_once(ABS_DIR."class_fb/func.class.php");
class Send 
{ 
//  Кнопки
    public function button_postback($title, $payload) //  Кнопка postback
       {
		   $button=array(
						type => "postback",
						title => $title,
						payload => $payload 
									
					);
			return $button;		
	   }	


 	  
    public function button_url($title, $url) //  Кнопка ссылка
       {
		   $button=array(
						type => "web_url",
						title => $title,
						url => $url,
						webview_height_ratio => "compact" 
									
					);
			return $button;		
	   }	
	   
	   public function button_url_me($title, $url) //  Кнопка ссылка
       {
		   $button=array(
						type => "web_url",
						title => $title,
						url => $url,
						webview_height_ratio => "full",
						messenger_extensions => true,			
					);
			return $button;		
	   }


	public function button_call($title, $payload) //  Кнопка звонок
       {
		   $button=array(
						type => "phone_number",
						title => $title,
						payload => $payload 
									
					);
			return $button;		
	   }

// Элементы карусели

	public function carusel($title, $subtitle, $item_url, $image_url, $buttons) // Заголовок, подзаголовок, ссылка, сслка на рисунок, массив кнопок
		{
			$carusel=array(
			title => $title,
            subtitle => $subtitle,
            item_url => $item_url,               
            image_url => $image_url,
            buttons => $buttons,
		
			);
			return $carusel;			
		}
	   
	   
// Ѕыстрые ответы

	public function quick_replies_text($title, $payload) // Быстрый ответ текст
		{
		$quick_replies = array(
        content_type => "text",
        title => $title,
        payload => $payload
		);
		return $quick_replies;
		}
	
	public function quick_replies_image($title, $payload, $image_url) // Быстрый ответ текст и изображение
		{
		$quick_replies = array(
        content_type => "text",
        title => $title,
        payload => $payload,
		image_url => $image_url
		);
		return $quick_replies;
		}
		
	public function quick_replies_location() // Быстрый ответ местонахождение
		{
		$quick_replies = array(
        content_type => "location",
      	);
		return $quick_replies;
		}
	
	
	
	// Cписки
	
	
	public function elements($title, $image_url, $subtitle, $url, $fallback_url, $titlebutton)
	 // Элементы списка
		{
			$default_action = array(
				type => "web_url",
				url => $url,
				messenger_extensions => true,
				webview_height_ratio => "tall",
				fallback_url => $fallback_url,
				
			);
			$buttons=array(
			  title =>  $titlebutton,
			  type => "web_url",
			  url => $url,
			  messenger_extensions => true,
			  webview_height_ratio => "tall",
			  fallback_url => $fallback_url,
			);
			
			$elements=array(
				title => $title,
				image_url => $image_url,
				subtitle => $subtitle,
				default_action => $default_action,
				buttons => array($buttons)
			);
			
			return $elements;
		}
	
	
	 	
	   
	   
	   
// ********* Cообщения ***************

    public function send_mess($id, $text) // Текст
       {
		   
		$recipient = array(
		  id => $id
		);
		
		
		
		$message = array(
		  text => Func::func_replace($text, $id)
		);

		$data_send_array=array(
		 recipient => $recipient,
		 message => $message
		);

		$data_send_json=json_encode($data_send_array); 
		$result=func::curl_send($data_send_json,'messages');
		
         return "Текстовое сообщение: ".$result;
       }
	   
	   
	public function send_img($id, $link) // Изображение
       {
		   
		$recipient = array(
		  id => $id
		);
		
		$payload = array(
		 "url" => $link,
		);
		
		$attachment = array (
		  "type" => "image",
		  "payload" => $payload
		);
		
		
		$message = array(
		  "attachment" => $attachment,
		);

		$data_send_array=array(
		 recipient => $recipient,
		 message => $message
		);

		$data_send_json=json_encode($data_send_array); 
		$result=func::curl_send($data_send_json,'messages');
		
         return "Отправка изображения: ".$result;
       }
	
	public function send_file($id, $link) // Файл
       {
		   
		$recipient = array(
		  id => $id
		);
		
		$payload = array(
		 "url" => $link,
		);
		
		$attachment = array (
		  "type" => "file",
		  "payload" => $payload
		);
		
		
		$message = array(
		  "attachment" => $attachment,
		);

		$data_send_array=array(
		 recipient => $recipient,
		 message => $message
		);

		$data_send_json=json_encode($data_send_array); 
		$result=func::curl_send($data_send_json,'messages');
		
         return "Отправка файла: ".$result;
       }
	
	public function send_audio($id, $link) // Аудио mp3
       {
		   
		$recipient = array(
		  id => $id
		);
		
		$payload = array(
		 "url" => $link,
		);
		
		$attachment = array (
		  "type" => "audio",
		  "payload" => $payload
		);
		
		
		$message = array(
		  "attachment" => $attachment,
		);

		$data_send_array=array(
		 recipient => $recipient,
		 message => $message
		);

		$data_send_json=json_encode($data_send_array); 
		$result=func::curl_send($data_send_json,'messages');
		
         return "Отправка Аудио-файла: ".$result;
       }
	   
	   
	   public function send_video($id, $link) // Видео mp4
       {
		   
		$recipient = array(
		  id => $id
		);
		
		$payload = array(
		 "url" => $link,
		);
		
		$attachment = array (
		  "type" => "video",
		  "payload" => $payload
		);
		
		
		$message = array(
		  "attachment" => $attachment,
		);

		$data_send_array=array(
		 recipient => $recipient,
		 message => $message
		);

		$data_send_json=json_encode($data_send_array); 
		$result=func::curl_send($data_send_json,'messages');
		
         return "Отправка видео: ".$result;
       }
	
	   
	   
	   
	    public function send_button($id, $text, $getbuttons) //  Кнопка 
       {
		   
		$recipient = array(
		  id => $id
			);
		
		$payload=array(
			template_type => "button",
			text => Func::func_replace($text, $id),
			buttons => $getbuttons
			);
		
		$attachment = array(
			type => "template", 
			payload => $payload,
			);
		
		$message = array(
			attachment => $attachment,
			);

		$data_send_array=array(
			 recipient => $recipient,
			 message => $message
			);

		$data_send_json=json_encode($data_send_array);  
		$result=func::curl_send($data_send_json,'messages');
        return "Кнопка: ".$result;
       }
	   
	   public function quick_replies($id, $text, $quick_replies) // Быстрый ответ
	   	{
			$recipient = array(
				id => $id
				);
			$message = array(
				text => $text,
				quick_replies => $quick_replies
				);
			$data_send_array=array(
				recipient => $recipient,
				message => $message
				);
		   	$data_send_json=json_encode($data_send_array);  
			$result=func::curl_send($data_send_json,'messages');
			return 	"Быстрый ответ: ".$result;
		}
	  
	  
	   public function send_list($id, $title_buttons, $payload, $elements) // Cписок
       {
		   
		$recipient = array(
		  id => $id
		);
		$buttons=array(
            title => $title_buttons,
            type =>  "postback",
            payload => $payload                        
            );
			
		$payload=array(
			template_type => "list",
			top_element_style => "compact",
			elements => $elements,
			buttons => array($buttons)
			);
		
		$attachment = array(
			type => "template", 
			payload => $payload,
			);
		
		
		
		$message = array(
			attachment => $attachment,
			
		);
		
		$data_send_array=array(
				recipient => $recipient,
				message => $message
				);
		   	$data_send_json=json_encode($data_send_array);  
			$result=func::curl_send($data_send_json,'messages');
			return "Список: ".$result;

	   }
	   
	public function send_generic($id, $elements) // Карусель - id получателя, массив с каруселями
		{
			
			$recipient = array(
		  id => $id
		);
		  $payload=array(
			template_type => "generic",
			elements => $elements,
			
			);
		  
		  $attachment = array(
			type => "template", 
			payload => $payload,
			);
		  
			$message = array(
			attachment => $attachment,
			);
			
			$data_send_array=array(
				recipient => $recipient,
				message => $message
			);
			
			$data_send_json=json_encode($data_send_array);  
			$result=func::curl_send($data_send_json,'messages');
			return "Карусель: ".$result;
		}
	

	public function notification($about, $text, $text2) // Уведомление администрации
       {
		db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
		$result = mysql_query("SELECT * FROM users WHERE users_group>1 and users_group<10");
		$myrow = mysql_fetch_array($result);
		do if ($myrow['user_id']!="")
		{
			$result_send="\tОтправка данных для {$myrow['first_name']} {$myrow['last_name']}\n\t".send::send_mess($myrow['user_id'], "{$text}\n{$about['first_name']} {$about['last_name']}\nПол: {$about['gender']}\nЛокаль: {$about['locale']}\nЧасовой пояс: {$about['timezone']}\n" );
			$result_send.="\n\tОтправка фото: ".send::send_img($myrow['user_id'], $about['profile_pic']);
			$result_send.="\n\tПервое сообщение: ".send::send_mess($myrow['user_id'], "{$text2}\n" );
		}
		while ($myrow = mysql_fetch_array($result));
		return "Уведомление администрации:\n".$result_send;
	   }	   
	   
	   
    
}
?>