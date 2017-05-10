<?
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                                                                       *
 * Использование:                                                                        *
 *                                                                                       * 
 * require ("date.class.php"); // Подключаем настоящий класс                             *
 *                                                                                       * 
 * echo date_class::crus_month($month); // Русское название месяца по номеру $month      *
 *                                                                                       *
 * echo date_class::today_rus(); // Русская дата сегодня                                 *
 *                                                                                       *
 * echo date_class::date_rus($d, $m, $y); // Русская дата из цифр ДЕНЬ, МЕСЯЦ, ГОД       *
 *                                                                                       * 
 * echo date_class::date_ru('Д, j м Y, G:i');   // Дата с русскими символами             * 
 * Дополнительные параметры для использования русских символов в функции времени:        *
 * д: полное текстовое представление дня недели                                          *
 * Д: полное текстовое представление дня недели (первый символ в верхнем регистре),      *
 * к: краткое текстовое представление дня недели,                                        *
 * К: краткое текстовое представление дня недели, (первый символ в верхнем регистре),    *
 * м: полное текстовое представление месяца                                              *
 * М: полное текстовое представление месяца (первый символ в верхнем регистре),          *
 * л: краткое текстовое представление месяца                                             *
 * Л: краткое текстовое представление месяца (первый символ в верхнем регистре),         *
 *                                                                                       * 
 * Для вывода даты из SQL используем следующий формат:                                   *
 * echo date_class::date_ru('Д, j м Y, G:i', strtotime($d)); , $d - дата из SQL          * 
 *                                                                                       * 
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
class date_class
{
	public function rus_month($month)
	{
		if ($month == '1')
			$month = 'января';
		if ($month == '2')
			$month = 'февраля';
		if ($month == '3')
			$month = 'марта';
		if ($month == '4')
			$month = 'апреля';
		if ($month == '5')
			$month = 'мая';
		if ($month == '6')
			$month = 'июня';
		if ($month == '7')
			$month = 'июля';
		if ($month == '8')
			$month = 'августа';
		if ($month == '9')
			$month = 'сентября';
		if ($month == '10')
			$month = 'октября';
		if ($month == '11')
			$month = 'ноября';
		if ($month == '12')
			$month = 'декабря';	
		$ret_moth=" {$month} ";
		return $ret_moth;
	}
	
	public function today_rus()
	{
		$day = date("j");
		$month = date ("m");
		$rus_month = Date_class::rus_month($month);
		$year = date("Y");
		$date = $day.$rus_month.$year;
		return "{$date} г.";
    }
	
	public function date_rus($d, $m, $y)
	{
		$rus_month = Date_class::rus_month($m);
		$date = "{$d} {$rus_month} {$y}";
		return "{$date} г.";
    }
	

    public function date_ru($formatum, $timestamp=0) {
  if (($timestamp <= -1) || !is_numeric($timestamp)) return '';
  $q['д'] = array(-1 => 'w', 'воскресенье','понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота');
  $q['Д'] = array(-1 => 'w', 'Воскресенье','Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота');
  $q['к'] = array(-1 => 'w', 'вс','пн', 'вт', 'ср', 'чт', 'пт', 'сб');
  $q['К'] = array(-1 => 'w',  'Вс','Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб');
  $q['м'] = array(-1 => 'n', '', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
  $q['М'] = array(-1 => 'n', '', 'Января', 'Февраля', 'Март', 'Апреля', 'Май', 'Июня', 'Июля', 'Август', 'Сентября', 'Октября', 'Ноября', 'Декабря');
  $q['л'] = array(-1 => 'n', '', 'янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек');
  $q['Л'] = array(-1 => 'n', '',  'Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек');

  if ($timestamp == 0)
    $timestamp = time();
  $temp = '';
  $i = 0;
  while ( (strpos($formatum, 'д', $i) !== FALSE) || (strpos($formatum, 'Д', $i) !== FALSE) ||
          (strpos($formatum, 'к', $i) !== FALSE) || (strpos($formatum, 'К', $i) !== FALSE) ||
          (strpos($formatum, 'м', $i) !== FALSE) || (strpos($formatum, 'М', $i) !== FALSE) ||
          (strpos($formatum, 'л', $i) !== FALSE) || (strpos($formatum, 'Л', $i) !== FALSE)) {
    $ch['д']=strpos($formatum, 'д', $i);
    $ch['Д']=strpos($formatum, 'Д', $i);
    $ch['к']=strpos($formatum, 'к', $i);
    $ch['К']=strpos($formatum, 'К', $i);
    $ch['м']=strpos($formatum, 'м', $i);
    $ch['М']=strpos($formatum, 'М', $i);
    $ch['л']=strpos($formatum, 'л', $i);
    $ch['Л']=strpos($formatum, 'Л', $i);
    foreach ($ch as $k=>$v)
      if ($v === FALSE)
        unset($ch[$k]);
    $a = min($ch);
    $temp .= date(substr($formatum, $i, $a-$i), $timestamp) . $q[$formatum[$a]][date($q[$formatum[$a]][-1], $timestamp)];
    $i = $a+1;
  }
  $temp .= date(substr($formatum, $i), $timestamp);
  return $temp;
}

}
?>