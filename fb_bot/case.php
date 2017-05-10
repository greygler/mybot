<?
class Bot_case
{
		
	
		
	public function bot_case_func($command,  $options, $text_mess, $user_id, $entry_id, $about, $last_message)
		{
			$about=Func::user_id($user_id);
			include("text.php");
			$result_array=array();
			
				switch ($command)
				{
					case "HELLO"; // Стартовое сообщение для пуска бота. В дальнейшем можно убрать
						if ($last_message!="") $send_last_message="Ваше последнее сообщение - «{$last_message}»";
						else $send_last_message="Это Ваше первое сообщение.";
						$hello="Привет. Это бот. Меня зовут «".BOT_NAME."»\n Мой ID: {$entry_id}.\n Тебя зовут {$about['first_name'] } {$about['last_name']},\nТвой ID: {$user_id}\n\n{$send_last_message}\n\nБот работает успешно!";
						$result_array[]=send::send_mess($user_id, $hello  );
					break;		
					
					case "STICKER"; // Реакция на стикер
					
						$result_array[]=send::send_mess($user_id,"Благодарю за стикер!");
					
					break;	

					/* 
					case "КОМАНДА"
					
						Команды
					
					break;

					*/
					
					
				default:
					if ($text_mess!="") {
							
							$co=Func::command_and_options($last_message); // Разбиваем команду на комманду и опции
							$result_array[]=send::send_mess($user_id, "{$about['first_name']}, cпасибо за сообщение\n{$text_mess},\nВ ближайшее время я с Вами свяжусь. ");
							$result_array[]=send::notification($about, "В бот поступило Сообщение:\n {$text_mess}\n Отправитель:");
							
						}
						else {
							$result_array[]=send::send_mess($user_id, "Неизвестная команда: {$command} {$options} ");
						
						}
                        
					break;
					
				} return $result_array;
		}
}
			
				
				
				
				
				

				
	
			
?>