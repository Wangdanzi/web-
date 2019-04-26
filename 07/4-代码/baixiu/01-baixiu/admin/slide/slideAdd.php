<?php 
    //获取前端传递 文本 连接 图片 ，  
    //将图片保存在服务器中
    //将文本 连接 图片在服务器中地址 存储到数据库中 
    //注意：  数据 中必须有图片，否则数据无效
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';


    include_once '../../fn.php';

    $file = $_FILES['image'];

    //在图片上传成功的情况，保存图片，获取数据  a.txt 
    if ($file['error'] === 0) {
        //保存图片
        $ext = explode('.', $file['name'])[1]; //txt  后缀名
        //生成新文件名
        $newName = 'uploads/'.time() . rand(1000, 9999). '.' . $ext;
        //转移
        move_uploaded_file($file['tmp_name'], '../../' . $newName);

        // $image = $newName;
        // $text = $_POST['text'];
        // $link = $_POST['link'];

        $info['image'] = $newName;
        $info['text'] = $_POST['text'];
        $info['link'] = $_POST['link'];

        //轮播图的数据在数据库中用json存储的， 
        //添加数据的思路
        //1-将我们数据用一维数组存
        //2-将数据的json字符串取出来
        $sql = "select * from options where id = 10";      
        $str = my_query($sql)[0]['value'];
        //3-转成二维数组
        $arr = json_decode($str, true); //得到二维数组
        // echo '<pre>';
        // print_r($arr);
        // echo '</pre>';
        //4-将我们一维数组追加到二位数组中
        $arr[] = $info;
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        //5-将二维数组转成json字符串
        //编码 将中文 unicode编码  \xxxx ---> 存储数据库中 xxxx
        //json_encode进行编码是，让中文不进行编码，中文原样存储到数据库中
        $str = json_encode($arr, JSON_UNESCAPED_UNICODE );
        echo $str;
        //6-将json字符串存回到数据库中
        $sql = "update options set value = '$str' where id = 10";
        //执行
        if(my_exec($sql)) {
            echo 'success!';
        } else {
            echo 'error!';
        }

    }

?>