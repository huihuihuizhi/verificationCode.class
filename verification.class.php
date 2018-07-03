<?php
	//验证码就是一张图片，通过画图的方法绘制出验证码
	//1.在浏览器中输出，给用户看    function showImage
	//2.保留在服务器中一份。因为用户提交的验证码还要和服务器匹配  function getCheckCode()
	class VerificationCode {
		private $width; //验证码的宽度
		private $height;//验证码的高度 
		private $codeNum;//验证码上有几个字符数
		private $image;   //图像资源
		private $disturbColorNum;//干扰元素 点的个数，每一个点是一个颜色
		private $checkCode;//写好的验证码字符  $this->createCheckCode();

		function __construct($width=80, $height=20, $codeNum=4){
			$this->width=$width;
			$this->height=$height;
			$this->codeNum=$codeNum;
			$this->checkCode=$this->createCheckCode();
			//设置干扰元素的个数，但是颜色的值不能超过255
			//$this->$disturbColorNum=$width*$height/15;
			// /15后不一定是整数，所以floor()取整
			$number=floor($width*$height/15);
			//设置干扰元素的个数，但是颜色的值不能超过255，就算240个。
			//四个验证码上的字符也是四个颜色，所以要剪掉这四个颜色
			if($number > 240-$codeNum){
				$this->disturbColorNum=	240-$codeNum;
			}else{
				$this->disturbColorNum=$number;
			}	
		}
		//通过访问该方法向浏览器中输出图像
		//$fontFace=""  字体的类型：楷体、宋体……，默认是空
		function showImage($fontFace=""){//显示图片
			//第一步：创建图像背景
			$this->createImage();
			//第二步：设置干扰元素
			$this->setDisturbColor();
			//第三步：向图像中随机画出文本
			$this->outputText($fontFace);
			//第四步：输出图像
			$this->outputImage();
		}
			
		//通过调用该方法获取随机创建的验证码字符串
		function getCheckCode(){
			//这样能保证 图片输出的验证码和服务器保存的验证码是同步的
			return $this->checkCode;
		}
        //第一步：创建图像背景
		private function createImage(){
			//创建图像资源   
			//imagecreatetruecolor(int x_size,int y_size)
			//显示一个黑色的框
			$this->image=imagecreatetruecolor($this->width, $this->height);
			//随机背景色
			//背景颜色不要太深，不好看出字，（0,255）会比较深，数字越大，颜色越浅，所以是（225,255）
			$backColor=imagecolorallocate($this->image, rand(225, 255), rand(225,255), rand(225, 255));
			//为背景添充颜色
			imagefill($this->image, 0, 0, $backColor);
			//设置边框颜色 
			//黑色的边框  就可以，不用随机
			$border=imagecolorallocate($this->image, 0, 0, 0);
			//画出矩形边框
			//在这个图像中，从0和0 开始画，画到指定的宽和高，再加上边框颜色
			//画边框的时候会画左边和上边的两条线，所以为了画整个边框，让它的宽和高都减一个像素
			imagerectangle($this->image, 0, 0, $this->width-1, $this->height-1, $border);
		}
        //第二步：设置干扰元素
        

		private function  setDisturbColor(){
			for($i=0; $i<$this->disturbColorNum; $i++){
				//点的颜色，不用管深浅，所以是（0,255）就可以
				$color=imagecolorallocate($this->image, rand(0, 255), rand(0, 255), rand(0, 255));
				//imagesetpixel()画一个单独像素，只是一个点
				//范围不超过范围，边框也不画，加上点的颜色				
				imagesetpixel($this->image, rand(1, $this->width-2), rand(1, $this->height-2), $color); 
			}
               //干扰元素——弧线，不能太多，会乱，所以10个就好
               //imagearc()——画椭圆弧
			for($i=0; $i<10; $i++){
				$color=imagecolorallocate($this->image, rand(200, 255), rand(200, 255), rand(200, 255));
				imagearc($this->image, rand(-10, $this->width), rand(-10, $this->height), rand(30, 300), rand(20, 200), 55, 44, $color);
			}
		}
        //创建随机验证码
		private function createCheckCode(){
			$code="23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKMNPQRSTUVWXYZ";
			$string='';
			//循环出验证码上的字符，循环次数是验证上字符的个数
			for($i=0; $i < $this->codeNum; $i++){
				//每循环一次 随机取出其中的一个字符
				//$code{}和$code[]一样，0取第一个，1取第二个……
				//strlen($code)字符串的长度 这个是最后一个字符之外的字符
				//rand(0, strlen($code)-1) 从第一个，到最后一个中的任意一个
				//取出一个连接一个，最后返回这个字符串
				$char=$code{rand(0, strlen($code)-1)};
				$string.=$char;
			}
			return $string;
		}
        //第三步：向图像中随机画出文本
		private function outputText($fontFace=""){
			for($i=0; $i<$this->codeNum; $i++){
				//每次的字体不同的颜色，每个字符就是一个颜色
				$fontcolor=imagecolorallocate($this->image, rand(0, 128), rand(0, 128), rand(0, 128));
				if($fontFace==""){
					//设置字体的大小（随机）
					$fontsize=rand(3, 5);
					//字体的位置（随机）
					$x=floor($this->width/$this->codeNum)*$i+3;//平均，且不挨在一起
					$y=rand(0, $this->height-15);//随机
					//imagechar()——每次输出一个字符，每个字符就是一个颜色，水平的画字符
					imagechar($this->image,$fontsize, $x, $y, $this->checkCode{$i},$fontcolor);
				}else{
					$fontsize=rand(12, 16);
					$x=floor(($this->width-8)/$this->codeNum)*$i+8;
					$y=rand($fontSize+5, $this->height);
					//imagettftext 用true type 字体向图像写入文本
					imagettftext($this->image,$fontsize,rand(-30, 30),$x,$y ,$fontcolor, $fontFace, $this->checkCode{$i});
				}
			}
		}
        //第四步：输出图像
		private function outputImage() {
			//imagetypes 返回当前PHP版本支持的图像类型
			if(imagetypes() & IMG_GIF){
				header("Content-Type:image/gif");
				imagepng($this->image);
			}else if(imagetypes() & IMG_JPG){
				header("Content-Type:image/jpeg");
				imagepng($this->image);
			}else if(imagetypes() & IMG_PNG){
				header("Content-Type:image/png");
				imagepng($this->image);
			}else if(imagetypes() & IMG_WBMP){
				header("Content-Type:image/vnd.wap.wbmp");
				imagepng($this->image);
			}else{
				die("PHP不支持图像创建");
			}
		}

		function __destruct(){//用完之后，销毁图像资源
			imagedestroy($this->image);
		}
	}


