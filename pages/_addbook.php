<?if(!isset($_SESSION['userid'])){echo "<script>location.href = '/login';</script>";exit();	}
	if(isset($_POST['book_name'])){
		$zap=urlencode($_POST['book_name']);
		$response = file_get_contents("https://www.googleapis.com/books/v1/volumes?q={$zap}");
		$response = json_decode($response,true);
	}
	if(isset($_POST["idbook"])){
		$response = file_get_contents("https://www.googleapis.com/books/v1/volumes/{$_POST['idbook']}");
		$response = json_decode($response,true);
		$title=$db->RealEscape($response['volumeInfo']["title"]);
		$db->query("INSERT INTO books (uid,title,favorite,which) VALUES ('{$_POST["idbook"]}','{$title}','0','{$_SESSION["userid"]}')");
		echo "<script>location.href = '/mybooks';</script>";
				exit();
	}
?>
	<div class="searchb">
	<form action="#" method="post"><input type="text" name="book_name" value="<?=$_POST['book_name'];?>"></input>
	<input type="submit" class="search_button" value="search">
	</form>
	</div>
	<div class="allbook">
	<?for($i=1;$i<count($response["items"]);$i++){?>
	<div class="book"><?echo $i." ".$response["items"][$i-1]['volumeInfo']["title"];?>
	<a href="#openModal<?=$i;?>" class="glow-button">Add book</a></div>
	<div id="openModal<?=$i;?>" class="modalDialog">
	<div>
		<a href="#close" title="Закрыть" class="close">X</a>
		<h2>Add book?</h2>
		<p><?=$response["items"][$i-1]['volumeInfo']["title"];?></p>
		<form action="" method="post"><input type="hidden" value="<?=$response["items"][$i-1]['id'];?>" name="idbook">
		<input type="submit" value="YES" class="glow-button"></form><a href="#close" title="Закрыть" class="glow-button2">NO</a>
	</div>
</div>
	<?}?>

	</div>
	<div class="navbar">
		<a href="/mybooks">My books</a>
			<a href="/addbook">Search book</a>
				<a href="/favorite">Favorite book</a>
				<a href="/exit">Exit</a>
				</div>