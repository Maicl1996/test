<?if(!isset($_SESSION['userid'])){echo "<script>location.href = '/login';</script>";exit();	}
	if(isset($_POST["idbook"])){
		$db->Query("DELETE FROM books where id = {$_POST['idbook']}");
	}
	if(isset($_POST["idbookfav"])){
		$db->Query("UPDATE books SET favorite = 1 where id = {$_POST['idbookfav']}");
		echo "<script>location.href = '/mybooks';</script>";
				exit();
	}
?>
<?$db->Query("SELECT * FROM books where which = {$_SESSION['userid']}");
	if($db->NumRows()>0){
		$nomer=1;?>
		<div class="allbook" style="top:10px;">
		<?while($onebook=$db->FetchArray()){?>
		<div class="book <?if($onebook['favorite']==1) echo "favor"?>"><p><?echo $nomer." ".$onebook["title"];?></p>
		<form action="" method="post" style="display:inline"><input type="hidden" value="<?=$onebook["id"];?>" name="idbookfav">
		<input type="submit" value="F" class="glow-button"></form>
		<a href="#openModal<?=$nomer;?>" title="delete book" class="glow-button2">D</a>
		<a href="/infobook/<?=$onebook['uid'];?>" title="info book" class="glow-button3">I</a></div>
			<div id="openModal<?=$nomer;?>" class="modalDialog">
	<div>
		<a href="#close" title="Закрыть" class="close">X</a>
		<h2>delete book?</h2>
		<p><?=$onebook["title"];?></p>
		<form action="" method="post"><input type="hidden" value="<?=$onebook["id"];?>" name="idbook">
		<input type="submit" value="YES" class="glow-button"></form><a href="#close" title="Закрыть" class="glow-button2">NO</a>
	</div>
</div>
	<?$nomer++;}?>
	</div>
	<?}else{?>
		<center><h3>there are no books in your library</h3></center>
	<?}?>
	<div class="navbar">
		<a href="/mybooks">My books</a>
			<a href="/addbook">Search book</a>
				<a href="/favorite">Favorite book</a>
					<a href="/exit">Exit</a>
				</div>