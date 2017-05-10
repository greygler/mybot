<? 
header("HTTP/1.1 200 OK\nContent-type: text/html; charset=utf-8");
require_once("config.php");
require_once("../class_vk/func.class.php");
require_once("../class_common/voice.class.php");

	
// Открываем файл для логов	
$f = fopen("textfile.json", "a");
fwrite($f, date("H:i:s")."\n");
// end Открываем файл для логов	

$json = file_get_contents('php://input'); 
$jdata=json_decode($json, true);
$type=$jdata['type'];
$group_id=$jdata['group_id'];
$secret=$jdata['secret'];

if (isset($jdata['object'])) {
	$send_id=$jdata['object']['id'];
	$date=$jdata['object']['date'];
	$user_id=$jdata['object']['user_id'];
	$out=$jdata['object']['out'];
	$read_state=$jdata['object']['read_state'];
	$title=$jdata['object']['title'];
	$body=$jdata['object']['body'];
	$text=$jdata['object']['text'];
	$from_id=$jdata['object']['from_id'];
	$post_owner_id=$jdata['object']['post_owner_id'];
	$post_id=$jdata['object']['post_id'];
	
}


$result_array=array();
if (($secret==TOKEN) OR ($type=="confirmation")) { 
	

switch ($type)
  {
	case "confirmation":
		if ($group_id==GROUP_ID) echo VERIFY_TOKEN;	
		if ($group_id==GROUP_ID1) echo VERIFY_TOKEN1;			
	break;
	
	case "message_new": // Пришло сообщение
		$user=func::about($user_id, $group_id);
		$is_group=Func::is_group($user_id, $group_id);
		//if (($is_group==0) AND ($user['count']>NO_GROUP)) 
		if ($is_group==0) 
		{
			if ($user['sex']=='1') $no_group_message=NO_GROUP_MESSAGE_W; else $no_group_message=NO_GROUP_MESSAGE;
			$result=func::send_message($user_id, func::func_replace($no_group_message, $user, $group_id), $group_id); 
		}
		else $result=func::random_message($user_id, $group_id);
		$count_array = json_decode($result, true);
		$count=$count_array['response'];
		$result_array[]=Func::log_user($user_id);
		$result_array[]=Func::log($user_id, $type, $send_id, $date, $out, $read_state, $title, $body); // Сохраняем логи
	break;
	
	case "message_reply": // Эхо ответа
	 	$result_array[]=Func::log($user_id, $type, $send_id, $date, $out, $read_state, $title, $body); // Сохраняем логи
	break;
	
	case "group_join": // Вступает в группу
	    $user=func::about($user_id, $group_id);	
		if ($user['sex']=='1') $is_group_message=IS_GROUP_MESSAGE_W; else $is_group_message=IS_GROUP_MESSAGE;
	 	$result=func::send_message($user_id, func::func_replace($is_group_message, $user, $group_id), $group_id);
	 	$result_array[]=Func::log($user_id, $type, $send_id, $date, $out, $read_state, $title, $body); // Сохраняем логи
	break;
	
	case "group_leave": // Выходит из группы
	    $user=func::about($user_id, $group_id);	
		if ($user['sex']=='1') $out_group_message=OUT_GROUP_MESSAGE_W; else $out_group_message=OUT_GROUP_MESSAGE;
	 	$result=func::send_message($user_id, func::func_replace($out_group_message, $user, $group_id), $group_id);
	 	$result_array[]=Func::log($user_id, $type, $send_id, $date, $out, $read_state, $title, $body); // Сохраняем логи
	break;
	
		
	case "wall_reply_new": // Пишет коммент
	    $user=func::about($user_id, $group_id);	
		if ($user['sex']=='1') $wall_reply="Ты чё накалякала?"; else $wall_reply="Ты чё накалякал?";
		
		$random_text=func::random_text();
		
		$data_send_array=array(
						owner_id => $post_owner_id,
						post_id => $post_id,
						from_group => 1,
						message  => $random_text,
						reply_to_comment => $send_id,
					);
		$json=func::send('wall.createComment', $data_send_array);
				
	 	$result=func::send_message($from_id, func::func_replace($wall_reply."\n".$random_text, $user, $group_id), $group_id);
	 	$result_array[]=Func::log($from_id, $type, $send_id, $date, $out, $read_state, $title, $text); // Сохраняем логи
	break;	
	
	default:
		echo ("");
	break;
  }
echo ("ok");
} else echo('Error');


fwrite($f, "json=".$json."\n"); // Лог json
fwrite($f, "type=".$type."\n"); // Лог json
fwrite($f, "group_id=".$group_id."\n"); // Лог json
fwrite($f, "secret=".$secret."\n"); // Лог json
foreach ($result_array as $key => $value)  fwrite($f, "result[{$key}] = {$value}\n"); // Сохраяем лог result
?>