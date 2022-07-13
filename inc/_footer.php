<?if(isset($_SESSION['type'])){
	echo "<div class='notif notif-color-{$_SESSION['type']}'><p>{$_SESSION['notif']}</p><div class='notif-progress'></div></div>";
	unset($_SESSION['type']);
	unset($_SESSION['notif']);
}?>
<script src="/script/script.js?ver=<?=$config->version?>"></script>
</body>
</html>