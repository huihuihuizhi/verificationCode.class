开发一个验证码类：
 
1、什么是验证码
      验证码就是一个图片
2、验证码的作用
     注册：将信息添加到服务器中，有一种攻击服务器的手段就是“灌水”。若添加一千万或一百万的数据，就会把数据表的空间占满。
               如果人为添加，会很长时间。
               所以可以写一个小程序：“注册机”，就是循环的向某个服务器添加数据。很快就可以完成。就攻击了你的网站
     登录：机器人会反复用不同用户名、不同密码 ，去暴力破解你的网站 ，若通过了，会用其做不正当的事情
         
   所以有向服务器添加数据的地方，就加上验证码，登录也加上验证码    
   验证码是给人看的，机器看不懂。
   但是有些程序比较厉害，可以通过验证码匹配其中的字母，所以在验证码中最好有干扰因素，
   和字母差不多的，这样通过像素匹配的时候，就不好识别。但是人可以识别
   
3、编写验证码类（PHP图像处理）
4、使用验证码
      在HTML代码中使用 <img >标签，使用src属性直接指定图片的URL地址即可

login.php 简单的使用这个验证码类