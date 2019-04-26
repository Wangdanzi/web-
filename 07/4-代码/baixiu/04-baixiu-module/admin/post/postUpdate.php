<?php 
    //获取前端传递数据，根据id更新数据
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';

//     <pre>Array
// (
//     [id] => 1007
//     [title] => 悯农2w
//     [content] => <p>锄禾日当午w</p>
//     [slug] => adsfa2
//     [category] => 4
//     [created] => 2018-08-31T10:09
//     [status] => published
// )
// </pre><pre>Array
// (
//     [feature] => Array
//         (
//             [name] => 7.jpg
//             [type] => image/jpeg
//             [tmp_name] => C:\Users\cc\AppData\Local\Temp\phpA995.tmp
//             [error] => 0
//             [size] => 547920
//         )

// )
// </pre>
    include_once '../../fn.php';

    //获取前端提交的数据
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $category = $_POST['category'];
    $created = $_POST['created'];
    $status = $_POST['status'];
    $feature = '';

    //如果上传了图片，则保存图片
    $file = $_FILES['feature'];
    //在图片上传成功的情况下，保存图片
    if($file['error'] === 0) {
        $ext = explode('.', $file['name'])[1]; //jpg
        $newName = 'uploads/'.time() . rand(10000, 99999) .  '.' . $ext;
        //转移
        move_uploaded_file($file['tmp_name'], '../../' . $newName);
        $feature = $newName; //将图片在服务器中地址，赋值给feature 
    }

    //进行更新
    //如果上次了新图片，用新图片覆盖旧图片，否则保留原图片
    if(empty($feature)) {
        //没有上传新图片
        $sql = "update posts set title = '$title', content = '$content', slug = '$slug', 
                category_id = $category, created = '$created', status = '$status' where id = $id";
    } else {
        //上传了新图片
        $sql = "update posts set title = '$title', content = '$content', slug = '$slug', 
                category_id = $category, created = '$created', status = '$status', feature = '$feature' where id = $id";
    }

    echo $sql; 

    //执行
    my_exec($sql); 

?>