<?PHP
class func{

	public $UserIP = "Undefined"; # IP пользователя
	public $UserCode = "Undefined"; # Код от IP
	public $TableID = -1; # ID таблицы
	public $UserAgent = "Undefined"; // Браузер пользователя

	/*======================================================================*\
	Function:	__construct
	Output:		Нет
	Descriiption: Выполняется при создании экземпляра класса
	\*======================================================================*/
	public function __construct(){
		$this->UserIP = $this->GetUserIp();
		$this->UserCode = $this->IpCode();
		$this->UserAgent = $this->UserAgent();
	}

	/*======================================================================*\
	Function:	__destruct
	Output:		Нет
	Descriiption: Уничтожение объекта
	\*======================================================================*/
	public function __destruct(){

	}



	/*======================================================================*\
	Function:	IpToLong
	Descriiption: Преобразует IP в целочисленное
	\*======================================================================*/
	public function IpToInt($ip){

		$ip = ip2long($ip);
		($ip < 0) ? $ip+=4294967296 : true;
		return $ip;
	}


	/*======================================================================*\
	Function:	IpToLong
	Descriiption: Преобразует целочисленное в IP
	\*======================================================================*/
	public function IntToIP($int){
  		return long2ip($int);
	}


	/*======================================================================*\
	Function:	GetUserIp
	Output:		UserIp
	Descriiption: Определяет IP пользователя
	\*======================================================================*/
	public function GetUserIp(){

		if($this->UserIP == "Undefined"){

			if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
   			{

			$client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "unknown" );
      		$entries = explode('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

      		reset($entries);

				while (list(, $entry) = each($entries))
				{
				$entry = trim($entry);
					if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
				 	{

					$private_ip = array(
						  '/^0\./',
						  '/^127\.0\.0\.1/',
						  '/^192\.168\..*/',
						  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
						  '/^10\..*/');

						$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

						if ($client_ip != $found_ip)
						{
					   	$client_ip = $found_ip;
					   	break;
						}

					}

				}

			$this->UserIP = $client_ip;
			return $client_ip;

			}else return ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "unknown" );

		}else return $this->UserIP;

	}


	/*======================================================================*\
	Function:	IsLogin
	Output:		True / False
	Input:		Строка логина, Маска, Длина ("4, 20") && ("10")
	Descriiption: Проверяет правильность ввода логина
	\*======================================================================*/
	public function IsLogin($login, $mask = "^[a-zA-Z0-9]", $len = "{4,20}"){

		return (is_array($login)) ? false : (preg_match("/{$mask}{$len}$/", $login)) ? $login : false;

	}

	/*======================================================================*\
	Function:	IsPassword
	Output:		True / False
	Input:		Строка пароля, Маска, Длина ("4, 20") && ("10")
	Descriiption: Проверяет правильность ввода пароля
	\*======================================================================*/
	public function IsPassword($password, $mask = "^[a-zA-Z0-9]", $len = "{4,20}"){

		return (is_array($password)) ? false : (preg_match("/{$mask}{$len}$/", $password)) ? $password : false;

	}

	/*======================================================================*\
	Function:	IsMail
	Output:		True / False
	Input:		Email
	Descriiption: Проверяет правильность ввода email адреса
	\*======================================================================*/
	public function IsMail($mail){

		if(is_array($mail) && empty($mail) && strlen($mail) > 255 && strpos($mail,'@') > 64) return false;
			return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $mail)) ? false : strtolower($mail);

	}

	/*======================================================================*\
	Function:	IpCode
	Output:		String, Example 255025502550255
	Input:		-
	Descriiption: Возвращает IP с замененными знаками "." на "0"
	\*======================================================================*/
	public function IpCode(){

		$arr_mask = explode(".",$this->GetUserIp());
		return $arr_mask[0].".".$arr_mask[1].".".$arr_mask[2].".0";

	}

	/*======================================================================*\
	Function:	GetTime
	Descriiption: Возвращаер дату
	\*======================================================================*/
	public function GetTime($tis = 0, $unix = true, $template = "d.m.Y H:i:s"){

		if($tis == 0){
			return ($unix) ? time() : date($template,time());
		}else return date($template,$unix);
	}
	public function TimeForCH($timer){
		$timer.=" 12:00:00";
		return strtotime($timer);
	}
	public function TimeForDA($timer){
		return date('d.m.Y',$timer);
	}
	public function TimerZak($timer){
		if(time()>$timer)
			return "время вышло";
			else{
				$obschee=$timer-time();
				$d=intdiv($obschee,86400);
				$obschee=$obschee%86400;
				$h=intdiv($obschee,3600);
				$obschee=$obschee%3600;
				$m=intdiv($obschee,60);
				$obschee=$obschee%60;
				$s=$obschee%60;
				$vivod=$d." дней ".$h." часов ".$m." минут ";
				return $vivod;
			}
		
	}
	public function Unicname($a,$b){
		$c=time();
		$c=date('H-i-s',$c);
		return $b.'-'.$c.'-'.$a;
	}
	/*======================================================================*\
	Function:	UserAgent
	Descriiption: Возвращает браузер пользователя
	\*======================================================================*/
	public function UserAgent(){

		return $this->TextClean($_SERVER['HTTP_USER_AGENT']);

	}
	
	/*======================================================================*\
	Function:	TextClean
	Descriiption: Очистка текста
	\*======================================================================*/
	public function TextClean($text){

		$array_find = array("`", "<", ">", "^", '"', "~", "\\");
		$array_replace = array("&#96;", "&lt;", "&gt;", "&circ;", "&quot;", "&tilde;", "");



		return str_replace($array_find, $array_replace, $text);

	}

	/*======================================================================*\
	Function:	ShowError
	Descriiption: Выводит список ошибок строкой
	\*======================================================================*/
	public function ShowError($errorArray = array(), $title = "Исправьте следующие ошибки"){

		if(count($errorArray) > 0){

		$string_a = "<div class='Error'><div class='ErrorTitle'>".$title."</div><ul>";

			foreach($errorArray as $number => $value){

				$string_a .= "<li>".($number+1)." - ".$value."</li>";

			}

		$string_a .= "</ul></div><BR />";
		return $string_a;
		}else return "Неизвестная ошибка :(";

	}

	/*======================================================================*\
	Function:	sha1Password
	Descriiption: Возвращает sha1_пароля
	\*======================================================================*/
	
 
  
}
?>