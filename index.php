<?session_start();
# Старт буфера
 function __autoload($name){ include("classes/_class.".$name.".php");}
 $func = new func;
 $config = new config;
 $db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
 @include("inc/_header.php");
 if(isset($_GET["menu"])){
		
			$menu = strval($_GET["menu"]);
			
			switch($menu){
				case "404": include("pages/_404.php"); break; 	
				case "login": include("pages/_login.php"); break;
				case "mybooks": include("pages/_mybooks.php"); break;
				case "addbook": include("pages/_addbook.php"); break;
				case "favorite": include("pages/_favorite.php"); break;
				case "infobook": include("pages/_infobook.php"); break;	
				case "exit": {@session_destroy();}; echo "<script>location.href = '/';</script>"; return; break;
			# Страница ошибки
			default: @include("pages/_404.php"); break;
			
			}
			
		}else @include("pages/_index.php");
 @include("inc/_footer.php");
?>