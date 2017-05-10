<?
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                                                                       *
 * Использование:                                                                        *
 *                                                                                       * 
 * require ("db.class.php"); // Подключаем настоящий класс                               *
 *                                                                                       * 
 * db::connect_db('Серевер_DB','Имя_DB','Логин_DB','Пароль_DB'); // Подключаемся к БД    *
 *                                                                                       *
 * $dbarray=db::db_to_array('Имя таблицы','Доп.параметры SQL-запроса','Имя поля id');    *
 * // экспортируем таблицу в массив вида $dbarray[$id, ИмяПоля]                          *
 *                                                                                       *
 * echo db::db_size(); // Размер БД                                                      *
 *                                                                                       * 
 * echo db::formatfilesize(Размер в байтах); // Преобразовываем байты в кБ и МБ (Бонус)  *
 *                                                                                       *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class Db
{
	public function connect_db($db_host, $db_name, $db_login, $db_pass)
	{
		$db = mysql_connect($db_host,$db_login,$db_pass) or die("MySQL сервер недоступен!".mysql_error());; /*Подключение к серверу */
        mysql_select_db($db_name,$db) or die("Нет соединения с БД".mysql_error()); /*Подключение к базе данных на сервере*/
        mysql_query("SET NAMES UTF8"); // UTF-8
        mysql_query("SET CHARACTER SET UTF8");
	}
	
	public function db_to_array($db_str, $db_param, $id)
	{
	    $db_connect="SELECT * FROM {$db_str} {$db_param}";
		$result = mysql_query($db_connect);
        $myrow = mysql_fetch_array($result);
         do
         { 
		    $id_db=$myrow[$id];
			foreach ($myrow as $key => $value)
			if (($key!=$id_db) And ($key!=$id)) $dbarray[$id_db][$key] = $value;
		 }
         while ($myrow = mysql_fetch_array($result));
		 return $dbarray;
	}
	
	public function formatfilesize( $data ) 
	{
     // bytes
        if( $data < 1024 ) {
        return $data . " bytes";   }
     // kilobytes
        else if( $data < 1024000 ) {
        return round( ( $data / 1024 ), 1 ) . "k"; }
     // megabytes
        else {
        return round( ( $data / 1024000 ), 1 ) . " MB"; }
    }
	
	public function db_size()
	{
	  $result = mysql_query( "SHOW TABLE STATUS" );
      $dbsize = 0;
      while( $row = mysql_fetch_array( $result ) ) {
      $dbsize += $row[ "Data_length" ] + $row[ "Index_length" ];
      $mysql = db::formatfilesize( $dbsize );
      }  
	  return $mysql;
    }
}
?>