<?
class Bot_case
{
	private function event($product, $day, $month, $year, $user_id)
	{
		db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
		//if (date('d'),date('m'),date("Y"))
		$db="SELECT * FROM `event` WHERE (product='{$product}' AND day='{$day}' AND month='{$month}' AND year='{$year}')";
		$result = mysql_query($db);
		$myrow = mysql_fetch_array($result);
		$result_array[]=send::send_mess($user_id, "!".$myrow['0']['id']);
		if ($myrow['0']['id']!="") {
		$event=array();
		do
			{
				$event_element=array(
					'name' => $myrow['name'],
					'description' => $myrow['description'],
					'location' => $myrow['location'],
					'time' => $myrow['hour'].":".$myrow['minute'],
					'hour' => $myrow['hour'],
					
					'price' =>   $myrow['price'],
					'pic' =>   $myrow['pic'],
					'url' => $myrow['url'],
					);
				$event[]=$event_element;
			}
		while ($myrow = mysql_fetch_array($result)); 
			return $event; }
			else return 0;
	}
	
	
	
		
	public function bot_case_func($command,  $options, $text_mess, $user_id, $entry_id, $about, $last_message)
		{
			$about=Func::user_id($user_id);
			include("text.php");
			$result_array=array();
			
				switch ($command)
				{
					case "HELLO";
				
				    $result[]=Send::send_mess($user_id, "Привет. Меня зовут ".BOT_NAME."Тебя зовут - {$about['first_name']} {$about['last_name']}\nБот работает успешно!");
				
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