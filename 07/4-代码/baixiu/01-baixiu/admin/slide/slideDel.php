<?php 
    include_once '../../fn.php';
    //根据前端传递的索引值进行删除 
    $id = $_GET['id'];
    //1-将数据库中json去出来
    $sql = "select * from options where id = 10";      
    $str = my_query($sql)[0]['value'];
    //2-转成数组
    $arr = json_decode($str, true);
    //3-从数据在删除指定id数据
    // array_splice(数组， 起始索引， 删几个);
    array_splice($arr, $id, 1);
    //4-数组转回json字符串
    $str = json_encode($arr, JSON_UNESCAPED_UNICODE);
    //5-将删除完成的json字符串更新会数据库
    $sql = "update options set value = '$str' where id = 10";
    //执行
    if(my_exec($sql)) {
        echo 'success!';
    } else {
        echo 'error!';
    }
?>