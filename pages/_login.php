<?
if(isset($_SESSION["userid"])){
	echo "<script>location.href = '/mybooks';</script>";
				exit();
}
if (isset($_POST['email'])){
		$db->Query("SELECT * FROM users where email = '{$_POST["email"]}'");
		if($db->NumRows()==1){
			$user=$db->fetchArray();
			if($user['password']==$_POST['pass']){
				$_SESSION['userid']=$user['id'];
				echo "<script>location.href = '/mybooks';</script>";
				exit();
			}else{
				$_SESSION['notif']="the password is not correct";
			$_SESSION['type']='1';
			echo "<script>location.href = '/login';</script>";exit();	
			}
			}
			else {$_SESSION['notif']="this email dont found";
			$_SESSION['type']='1';
			echo "<script>location.href = '/login';</script>";exit();
			}
		}
?>
<form action="" method="post" class="ui-form">
<h3>Log In</h3>
<div class="form-row">
<input type="text" name="email"required><label for="email">Email</label>
</div>
<div class="form-row">
<input type="password" name="pass"required><label for="password">Password</label>
</div>
<p><input type="submit" value="Registration"></p>
</form>
<center><h3>dont have an account <a href="/">Reg In</a></h3></center>