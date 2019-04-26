<?php 
    include_once '../../fn.php';
    //1-获取前端表单提交的数据和图片
    //2-将数据和图片的地址存储在数据库中

    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';

    
// Array
// (
//     [feature] => Array
//         (
//             [name] => 2.jpg
//             [type] => image/jpeg
//             [tmp_name] => C:\Users\cc\AppData\Local\Temp\php514A.tmp
//             [error] => 0
//             [size] => 584667
//         )

// )

    //1-获取表单数据
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $category = $_POST['category'];
    $created = $_POST['created'];
    $status = $_POST['status'];
    //文章的作者谁是？ 就是当前登录的用户
    session_start();
    $userid = $_SESSION['user_id'];
    $feature = ''; //用于存放图片在服务器中地址


   
    $file = $_FILES['feature'];
   //2-如果成功上传了图片，则保存图片到服务器中 
   if($file['error'] === 0) {  // false '', null 
        //随机生成新文件名，后缀名不变   
        $ext = explode('.', $file['name'])[1];    
        //图片一定存放在uploads文件夹中，有文件结构复杂，不同的页面../ 也不一样，后面我们手动拼接../   
        $newName = 'uploads/'.time() . rand(1000, 9999) . '.' . $ext;     
        //移动临时文件到指定目录
        move_uploaded_file($file['tmp_name'], '../../'.$newName);  
        $feature = $newName;
   }


   //3-将获取的数据和图片在服务器中地址存储到数据库中
   //注意： 文章别名不同重复的
   //准备sql  外双内单 
   $sql = "insert into posts (title, content, slug, category_id, created, status, user_id, feature ) 
                      values ('$title', '$content', '$slug', $category, '$created', '$status', $userid, '$feature')";

  echo $sql;

  //执行
  my_exec($sql);

  //在保证上面代码没有错误的情况下，在进行页面跳转  
  //跳转到文章列表页
  header('location:../posts.php');
?>