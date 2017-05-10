<?
class date_rus {
	
	public function rus_moth($moth)
	{
		switch ($moth)
		{
			case "1";
			 $rus_moth="Январь";		
			break;
			
			case "2";
			 $rus_moth="Февраль";		
			break;
			
			case "3";
			 $rus_moth="Март";		
			break;
			
			case "4";
			 $rus_moth="Апрель";		
			break;
			
			case "5";
			 $rus_moth="Май";		
			break;
			
			case "6";
			 $rus_moth="Июнь";		
			break;
			
			case "7";
			 $rus_moth="Июль";		
			break;
			
			case "8";
			 $rus_moth="Август";		
			break;
			
			case "9";
			 $rus_moth="Сентябрь";		
			break;
			
			case "10";
			 $rus_moth="Октябрь";		
			break;
			
			case "11";
			 $rus_moth="Ноябрь";		
			break;
			
			case "12";
			 $rus_moth="Декабрь";		
			break;
		}
		return $rus_moth;
	}
	
	public function rus_moths($moth)
	{
		switch ($moth)
		{
			case "1";
			 $rus_moth="Января";		
			break;
			
			case "2";
			 $rus_moth="Февраля";		
			break;
			
			case "3";
			 $rus_moth="Марта";		
			break;
			
			case "4";
			 $rus_moth="Апреля";		
			break;
			
			case "5";
			 $rus_moth="Мая";		
			break;
			
			case "6";
			 $rus_moth="Июня";		
			break;
			
			case "7";
			 $rus_moth="Июля";		
			break;
			
			case "8";
			 $rus_moth="Августа";		
			break;
			
			case "9";
			 $rus_moth="Сентября";		
			break;
			
			case "10";
			 $rus_moth="Октября";		
			break;
			
			case "11";
			 $rus_moth="Ноября";		
			break;
			
			case "12";
			 $rus_moth="Декабря";		
			break;
		}
		return $rus_moth;
	}
	
	
	public function rus_week($weekday) // date("w");
	{
		if ($weekday==0) $weekday=7;
		switch ($weekday)
		{
			case "1";
			 $rus_week="Понедельник";		
			break;
			
			case "2";
			 $rus_week="Вторник";		
			break;
			
			case "3";
			 $rus_week="Среда";		
			break;
			
			case "4";
			 $rus_week="Четверг";		
			break;
			
			case "5";
			 $rus_week="Пятница";		
			break;
			
			case "6";
			 $rus_week="Суббота";		
			break;
			
			case "7";
			 $rus_week="Воскресенье";		
			break;
			
			
		}
		return $rus_week;
	}
}
?>