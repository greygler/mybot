<h2>Формируем базу данных:</h2><p align="left" style="width: 850px;">
<?
require_once("../config.php");
require_once("../../class_common/db.class.php");

Echo ("<br>");
db::connect_db(DB_HOST,DB_NAME,DB_LOGIN,DB_PASS);
echo ("<strong>Таблица logs: </strong>");
$result = mysql_query("CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `recipient_id` varchar(20) NOT NULL,
  `entry_time` varchar(20) NOT NULL,
  `timestamp` varchar(20) NOT NULL,
  `mid` varchar(20) NOT NULL,
  `message` text CHARACTER SET utf8mb4 NOT NULL,
  `readmark` tinyint(1) NOT NULL,
  `delivery` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

if ($result) echo "Создана успешно<br>"; else "Ошибка в создании<br>";

echo ("<strong>Таблица products: </strong>");
$result = mysql_query("CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `pic` varchar(100) NOT NULL,
  `pic_cart` varchar(50) NOT NULL,
  `description` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

if ($result) echo "Создана успешно<br>"; else "Ошибка в создании<br>";

echo ("<strong>Таблица users: </strong>");
$result = mysql_query("CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `profile_pic` varchar(256) NOT NULL,
  `users_pic` varchar(100) NOT NULL,
  `locale` varchar(10) NOT NULL,
  `timezone` int(11) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `is_payment_enabled` tinyint(1) DEFAULT NULL,
  `last_time` varchar(21) NOT NULL,
  `last_message` text CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(256) NOT NULL,
  `cart` varchar(256) NOT NULL,
  `count_revision` tinyint(4) NOT NULL,
  `users_group` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

if ($result) echo "Создана успешно<br>"; else "Ошибка в создании<br>";
echo ("<strong>Таблица users_group: </strong>");
$result = mysql_query("CREATE TABLE IF NOT EXISTS `users_group` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8");
if ($result) echo "Создана успешно, "; else "Ошибка в создании, ";

$result = mysql_query("INSERT INTO `users_group` (`id`, `name`) VALUES
(0, 'Заблокирован'),
(1, 'Пользователь'),
(3, 'Разработчик'),
(2, 'Администратор'),
(4, 'Тестеровщик'),
(10, 'Бот');
");
if ($result) echo "Наполнение успешно<br>"; else "Ошибка в наполнении<br>";
?>
</p></center>