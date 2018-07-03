<?php
	session_start();//开启session会话
	include "verification.class.php";

	$code=new verificationCode(80, 20, 4);//创建验证码对象

	$code->showImage();   //输出到页面中供 注册或登录使用

	$_SESSION["code"]=$code->getCheckCode();  //将验证码保存到服务器中

