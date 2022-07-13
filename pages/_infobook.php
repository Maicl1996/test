<?if(!isset($_SESSION['userid'])){echo "<script>location.href = '/login';</script>";exit();	}
	if(!isset($_GET['uid'])){echo "<script>location.href = '/mybook';</script>";exit();	}
	$response = file_get_contents("https://www.googleapis.com/books/v1/volumes/{$_GET['uid']}");
		$response = json_decode($response,true);
?>
		<div class="allbook" style="padding-left:25px;width:90%;top:10px;">
		<h3>Title: <?echo $response["volumeInfo"]["title"];?></h3>
		<h3>Authors: <?
		for($i=0;$i<count($response["volumeInfo"]["authors"]);$i++)
		echo $response["volumeInfo"]["authors"][$i]."<br>";?>
	</h3>
		<h3>Description: <?echo $response["volumeInfo"]["description"];?></h3>
	</div>
	<div class="navbar">
		<a href="/mybooks">My books</a>
			<a href="/addbook">Search book</a>
				<a href="/favorite">Favorite book</a>
				<a href="/exit">Exit</a>
				</div>