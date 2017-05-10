<?
require_once("../class_common/db.class.php");
require_once("../class_common/voice.class.php");
class Func // Имя класса с большой буквы
{
	const LINK_VK="https://api.vk.com/method/";
	const OAUTH_VK="https://oauth.vk.com/authorize/";
	
	public function func_replace($str, $user, $group_id) // Подстановка данных в строку (строка текста, массив с данными пользователя, ID группы);
		{
			
			$text = str_replace("%first_name%", $user['first_name'], $str); // Имя
			$text = str_replace("%last_name%", $user['last_name'], $text); //Фамилия
			$text = str_replace("%city%", $user['city_title'], $text); // Город
			$text = str_replace("%group_id%", $group_id, $text); // ID группы
			
			return $text;
		}		
		
	public function send_message($id, $message, $group_id) // Отправка сообщения (ID пользователя, сообщение, ID группы)
	{
	if ($group_id==GROUP_ID) $key=KEY;	
	if ($group_id==GROUP_ID1) $key=KEY1;
    $url = Func::LINK_VK.'messages.send';
    $params = array(
        'user_id' => $id,    // Кому отправляем
        'message' => $message,   // Что отправляем
        'access_token' => $key,  // 
        'v' => VER_API,
    );

    // В $result вернется id отправленного сообщения
    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));
	return $result;
	}
		
	public function random_text()
	{
		db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
		$bd="SELECT text FROM zeka ORDER BY RAND() LIMIT 1";
		$result = mysql_query($bd);
		$myrow = mysql_fetch_array($result);
		return $myrow['text'];
	}
		
		
	public function random_message($id, $group_id) // Отправка рандомного сообщения (ID пользователя, ID группы)
	{
	if ($group_id==GROUP_ID) $key=KEY;	
	if ($group_id==GROUP_ID1) $key=KEY1;
    $url = Func::LINK_VK.'messages.send';
    $message=func::random_text();
	
	$voice=voice::voice_ru(str_replace(" ","%20", $message),'ermil', '1.0');
	$message1=$message."\n".$voice;
    $params = array(
        'user_id' => $id,    // Кому отправляем
        'message' => $message,   // Что отправляем
        'access_token' => $key,  // 
        'v' => VER_API,
    );

    // В $result вернется id отправленного сообщения
    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));
	
	return $result;
	}	
		
	public function send($method, $params_array, $group_id) // Отправка события (метод, параметры, ID группы - не обязательно)
	{
    $url = Func::LINK_VK.$method;
	if ($group_id==GROUP_ID) $key=KEY; else	
	if ($group_id==GROUP_ID1) $key=KEY1; else $key=KEY_A;
    $params_key = array(
        'access_token' => $key, 
        'v' => VER_API,
    );
		$params=array_merge($params_array,  $params_key);
  
    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));
	return $result;
	
	
	}
	
	public function send_doc($method, $params_array, $group_id) // Отправка события (метод, параметры, ID группы - не обязательно)
	{
    $url = Func::LINK_VK.$method;
	
  
    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));
	return $result;
	
	
	}
	
    public function is_group($user_id, $group_id) // Проверка, состоит ли в группе пользователь, обновляем сосотяние в базе (ID пользователя, ID группы)
	{
		$data_send_array=array(
			group_id => $group_id,
			user_id => $user_id,
			extended  => 0,
					);
		$json=Func::send('groups.isMember', $data_send_array, $group_id);
		$is_group = json_decode($json, true);
		$bd="UPDATE users SET is_group='{$is_group['response']}' WHERE user_id='{$user_id}'"; // обновляем сосотяние в базе
		$result = $is_group['response'];
		return $result;
				
	}
		   
	public function about($user_id, $group_id) // Возвращаем данные о пользователе (ID пользователе, )
		{
			db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
			$bd="SELECT * FROM users WHERE user_id='{$user_id}'";
			$result = mysql_query($bd);
			$myrow = mysql_fetch_array($result);
			$users_array=array();
			if ($myrow['id']!="") {
				foreach($myrow as $key => $value) if ($key!="") $users_array[$key] = $value;
				$users_array['db'] = 'ok';
				$users_array['count']=$myrow['count']+1;
				$bd="UPDATE users SET count='{$users_array['count']}' WHERE user_id='{$user_id}'"; 
				$result = mysql_query ($bd);
						        				 
				} else {
					$data_send_array=array(
						user_ids => $user_id,
						fields =>"photo_50, city, verified, bdate, contacts, country, sex", // Что забираем о пользователе
						name_case => "nom",
						lang  => 0,
					);
				$json=func::send('users.get', $data_send_array);
				$users= json_decode($json, true);
				foreach($users['response'][0] as $key => $value) if (($key!="city") or ($key!="country")) $users_array[$key] = $value;
				$users_array['city_id']=$users['response'][0]['city']['id'];
				$users_array['city_title']=$users['response'][0]['city']['title'];
				$users_array['country_title']=$users['response'][0]['country']['id'];
				$users_array['country_id']=$users['response'][0]['country']['title'];
				$bd="INSERT INTO users (user_id, first_name, last_name, sex, bdate, city_id, city_title, country_id, country_title, photo_50, group_id) VALUES ('{$users['response'][0]['id']}','{$users['response'][0]['first_name']}', '{$users['response'][0]['last_name']}', '{$users['response'][0]['sex']}', '{$users['response'][0]['bdate']}', '{$users['response'][0]['city']['id']}', '{$users['response'][0]['city']['title']}', '{$users['response'][0]['country']['id']}', '{$users['response'][0]['country']['title']}', '{$users['response'][0]['photo_50']}', '{$group_id}')"; 
					$result = mysql_query ($bd);

				}
					return $users_array;
			}
			
			
	public function code_flow($client_id, $group_ids)
		{
			$data=array(
			client_id => $client_id,
			redirect_uri => "https://my-bot.xyz/zekabot/atz.php",
			group_ids => $group_ids,
			display => 'page',
			scope => 'wall, offline, ',
			response_type => 'code',
			v => VER_API,
			
			);
			$url=func::OAUTH_VK.'?'.http_build_query($data);
			$result = file_get_contents($url, false);
			return $url."<br>".$result;
		}
	
	
	// ЛОГИ:
	
	public function log($user_id, $type ,$send_id, $date, $out, $read_state, $title, $body) // Запись в лог сообщения (ID пользователя, ID сообщения, Дата\время, входящее\исходящее, прочитано, заголовок, сообщение)
       {
		db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
		$bd="INSERT INTO logs (user_id, type, send_id, date, out_state, read_state, title, body) VALUES ('{$user_id}','{$type}', '{$send_id}', '{$date}', '{$out}', '{$read_state}', '{$title}', '{$body}')"; 
		
		$result = mysql_query ($bd);
		
		
		if ($result == 'true') {$result="log: Информация добавлена успешно!";} else {$result= " log: Информация не добавлена!";}
			 
		return $result;
       }	

	   
public function log_user($id) // Запись в лог последнего времени общения (ID пользователя)
       {
		db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
		$bd="UPDATE users SET timestamp='".time()."' WHERE user_id='{$id}'"; 
			$result = mysql_query ($bd);
		
			if ($result == 'true') {$result="log_user: Информация добавлена успешно!";} else {$result= "log_user: Информация не добавлена!";}
			 
		return $result;
       }
		
}