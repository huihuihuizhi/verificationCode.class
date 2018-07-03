<?php
	session_start();
	?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title></title>
	</head>
	<body>
		<?php
	
	//Notice: Undefined index: code in D:\phpstudy\WWW\verificationCode.class\login.php on line 10
	//echo $_POST["code"]."<br>"; //得到的验证码
	//echo $_SESSION["code"]."<br>";//服务器中保存的验证码
     //将表单中的到的验证码和服务器中的验证码全部转成大写后，判断是否一样（大小写不一样，无法判断，转成一样类型的去判断一下就好）
	if(strtoupper($_POST["code"])==strtoupper($_SESSION["code"])){
		echo "ok";
	}else{
		echo "error";
	}
?>

	<form action="login.php" method="post"><!---提交到本页面->
		user:<input type="text" name="usenrame"><br>
		pass:<input type="passowrd" name="pass"><br>
        <!--点击验证码就会更新，类似看不清换一张的效果onclick="this.src='code.php
        	浏览器有缓存的功能，同一个地址他认为是同一张图片，所以让图片你的额地址不一样 后面加一个随机数   ?'+Math.random()
        	
        	-->
        	user:<input type="text" name="usenrame"><br>
		pass:<input type="passowrd" name="pass"><br>
        <!--键盘抬起的时候  用JavaScript转成大写
        	 onkeyup="if(this.value!=this.value.toUpperCase()) this.value=this.value.toUpperCase()"
        	-->
		code: <input type="="itext" name="code" onkeyupf(this.value!=this.value.toUpperCase()) this.value=this.value.toUpperCase()"> <img src="code.php" onclick="this.src='code.php?'+Math.random()"><br>
		

		<input type="submit" name="sub" value="login"><br>
	</form>


	</body>
</html>
