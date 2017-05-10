<?
class Voice
{
	
	const LINK_YA="https://tts.voicetech.yandex.net/generate?";
	
	public function voice_ru($text, $speaker, $speed)
	{
		$voice=array(
		text => $text,
		format => 'mp3', //  mp3 — аудио в формате MPEG; wav — аудио в формате PCM 16 бит;  opus — аудио в формате Opus - OGG.
		speaker => $speaker, // женские голоса: jane, oksana, alyss и omazh;   мужские голоса: zahar и ermil.
		speed => $speed, //  3.0 — самый быстрый темп;  1.0 — средняя скорость человеческой речи; 0.1 — самый медленный темп.
		emotion => 'good',   //  good — радостный, доброжелательный;  evil — раздраженный;  neutral — нейтральный (используется по умолчанию).
		lang => 'ru_RU', //ru-RU — русский язык, en-US — английский язык, uk-UK — украинский язык, tr-TR — турецкий язык.
		key => YA_KEY,
);
$url  = Voice::LINK_YA;

foreach ($voice as $key => $value) $url=$url."{$key}={$value}&";

//echo $url;
$return=file_get_contents($url, false);

$path = DIR_AUDIO.'1'.".mp3";
				
		$return=file_put_contents($path, file_get_contents($url));
//echo $url;
return $url;
	}
	
}