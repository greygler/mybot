<?
header("Content-type: text/html; charset=utf-8");
require_once("config.php");
require_once("text.php");
require_once("../class_fb/send.class.php");
require_once("../class_fb/options.class.php");

$buttons1=send::button_postback("Отправить сообщение", "message");
$buttons2=send::button_postback("Заказать бота", "more");
$buttons3=send::button_postback("Просчитать бота", "order");
$call_to_actions=array($buttons1, $buttons2, $buttons3);
 
//$call_to_actions_button=Array(send::button_url("О нас", "https://my-bot.xyz"));
 echo options::Persistent_Menu("Меню", $call_to_actions, send::button_url("О нас", "https://my-bot.xyz"));
