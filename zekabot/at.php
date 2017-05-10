<?
header("HTTP/1.1 200 OK\nContent-type: text/html; charset=utf-8");
require_once("config.php");
require_once("../class_vk/func.class.php");
require_once("../class_common/voice.class.php");

/* $params = array(
        access_token => '05d37cc47fcf1260a81aec6dcee298703820025a9f5762b7bc06181e43378c809d86675a219096cda8200',
		group_id => '144862858',
        type => 'audio_message',    // Кому отправляем
         v => '5.3',
    );

	echo func::send_doc('docs.getUploadServer', $params) // Отправка события (метод, параметры, ID группы - не обязательно)
	
	 */
		
	$audio= voice::voice_ru('Я базарю по фене толк+ово! Могу запарафинить любого! Не веришь?!?! Ты че рамсы попутал?!?! Накалякай мне маляву','ermil', '1.0');
	
	echo $audio;
	 echo "<audio controls='controls'>"; // Выводим тег аудио с панелью управления
    echo "<source type='audio/mpeg' src='".$audio."' />"; // Подключаем путь к аудио-файлу
    echo "</audio>"
		
?>