<?
if(isset($_SESSION["userid"])){
	echo "<script>location.href = '/mybooks';</script>";
				exit();
}
	if (isset($_POST['name'])){
		$db->Query("SELECT * FROM users where email = '{$_POST["email"]}'");
		if($db->NumRows()==0){
			$user=$db->fetchArray();
		if($func->IsMail($_POST["email"])){
			if($_POST["pass"]==$_POST["pass2"]){
				$db->query("INSERT INTO users (name,email,password) VALUES ('{$_POST["name"]}','{$_POST["email"]}','{$_POST["pass"]}')");
				$_SESSION['notif']="registration was successful";
				$_SESSION['type']='3';
				echo "<script>location.href = '/login';</script>";
				exit();
			}
			else {$_SESSION['notif']="passwords don't match";
			$_SESSION['type']='1';
			echo "<script>location.href = '';</script>";exit();
			}
		}
		else {$_SESSION['notif']="the mail has an incorrect format";
			$_SESSION['type']='1';
			//echo "<script>location.href = '';</script>";exit();
			}
		} 
		else {$_SESSION['notif']="this mail is already in use";
			$_SESSION['type']='1';
			echo "<script>location.href = '';</script>";exit();
			}
	}
?>
<form action="" method="post" class="ui-form">
<h3>registration</h3>
<div class="form-row">
<input type="text" name="name"required><label for="Name">Name</label>
</div>
<div class="form-row">
<input type="text" name="email"required><label for="email">Email</label>
</div>
<div class="form-row">
<input type="password" name="pass"required><label for="password">Password</label>
</div>
<div class="form-row">
<input type="password"  name="pass2"required><label for="confirm password">Confirm password</label>
</div>
<p><input type="submit" value="Registration"></p>
</form>
<center><h3>already have an account <a href="/login">Log In</a></h3></center>