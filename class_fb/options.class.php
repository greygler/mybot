<?
require_once(ABS_DIR."class_fb/func.class.php");

class Options // Класс опций
{
        
	
	
    

	public function Get_Started($payload) // Активация стартового экрана "GET_STARTED_PAYLOAD"
       {
		  /*  $payload_array=array(
		   payload => $payload,
		   );
		   
		 $call_to_actions = array(
		 payload => $payload_array,
		);
		$data_send_array=array(
		setting_type => "call_to_actions",
		thread_state => "new_thread",
		call_to_actions => $call_to_actions,
		); 
		
		$data_send_json=json_encode($data_send_array); */
		
		$data_send_json='{
  "setting_type":"call_to_actions",
  "thread_state":"new_thread",
  "call_to_actions":[
    {
      "payload":"'.$payload.'"
    }
  ]
}'; // Немного говнокода - иначе FB не принимает (((
//print_r($data_send_json);
		$result=func::curl_send($data_send_json,'thread_settings');
		return $result;
       }  

	public function white_listed($server)
	{
		$data_send_json='{"whitelisted_domains":["'.$server.'"]}'; // Еще немного говнокода - иначе FB не принимает (((
//print_r($data_send_json);
		$result=func::curl_send($data_send_json,'messenger_profile');
		return $result;
	}

	 public function Setting_Greeting_Text($text) // Настройка приветствующего текста
		   {
			
			$greeting = array(
					  
		     text => $text,
			 
			);

			

			$data_send_array=array(
					setting_type => greeting,
					greeting => $greeting,
			);
			$data_send_json=json_encode($data_send_array);  
			$result=func::curl_send($data_send_json,'thread_settings');
			 return $result;
		   } 
		   
	public function Get_messenger_profile() // Чтение Профиля мессенджера
		   {
			$json = file_get_contents(Func::LINK_FB.'me/messenger_profile?fields=account_linking_url,persistent_menu,target_audience&access_token='.TOKEN);
			$profile = json_decode($json, true);
			return $json; //$profile;
		   }
	   
	   
	   public function Persistent_Menu($title, $call_to_actions, $call_to_actions_button) // Постоянное меню - массив кнопок, кнопка URL
	   {
		
		$call_to_actions_array1 = array(
			title => $title,
			type => "nested",
			call_to_actions => $call_to_actions
		);
		  
		
		  
		  
		$call_to_actions_array =array($call_to_actions_array1, $call_to_actions_button); 
		
		$persistent_menu1=array(
			locale => "default",
			composer_input_disabled => false,
			call_to_actions => $call_to_actions_array,
		);
		$persistent_menu2=array(
			locale => "ru_RU",
			composer_input_disabled => false,
			call_to_actions => $call_to_actions_array,
		);
		$persistent_menu=array($persistent_menu1, $persistent_menu2);
		
		$data_send_array = array(
          persistent_menu => $persistent_menu
           );
		$data_send_json=json_encode($data_send_array);  
		$result=func::curl_send($data_send_json,'messenger_profile');
         return $data_send_json.",<br>".$result;   
	   }
	   
}	   
?>