<?php 
   //1-如果请求方式是post 获取表单提交的数据 
  //  echo '<pre>';
  //  print_r($_SERVER['REQUEST_METHOD']);
  //  echo '</pre>';
   include_once '../fn.php';

   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //2-获取用户提交数据
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        // echo $email;
        // echo $pwd;
        //3-判断用户和密码是否为空
        if (empty($email) || empty($pwd)) {
            $msg = '用户名或者密码为空！';
        } else {
          //4- 数据存在根据用户名去数据库查询对应密码 
          //准备sql  外双内单
          $sql = "select * from users where email = '$email'";
          //查询
          $data = my_query($sql);

          // echo '<pre>';
          // print_r($data[0]);
          // echo '</pre>';

          // 5-判断是否查询到密码： ---> 没有查询到密码说明用户名不存在
          if(empty($data)) {
            //用户名不存在
            $msg = '用户名不存在';
          } else {
              //6-如果密码存在，判断用户输入的密码和数据数据库是否一致， 一致则登录成功
              $data = $data[0];
              if ($pwd == $data['password']) {
                //登录成功
                //给用户添加标记
                session_start();
                //在session文件中存放用户id 
                $_SESSION['user_id'] = $data['id'];
                //跳转到网站的首页
                header('location:./index1.php');
              } else {
                //密码错误
                $msg = '密码错误！';
              }
          }
        }     
   }

 


?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <!-- action="" 默认将请求提交给当前页面 -->
    <form class="login-wrap" action="" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <!-- 判断是否有错误的标准：判断$msg存在  -->

      <?php if(!empty($msg)){?>
        <div class="alert alert-danger">
          <strong>错误！</strong> <?php echo $msg ?>
        </div>
      <?php } ?>

      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input  id="email" 
                type="email" 
                name="email" 
                class="form-control" 
                placeholder="邮箱" 
                autofocus
                value="<?php  echo !empty($msg) ? $email : '' ?>"
                >
          <!-- 优化：如果登录失败  用户名继续保留之前用户输入的 -->
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input  id="password" 
                type="password" 
                name="password" 
                class="form-control" 
                placeholder="密码">
      </div>     
      <input  class="btn btn-primary btn-block" type="submit" value="登录">
    </form>
  </div>
</body>
</html>
