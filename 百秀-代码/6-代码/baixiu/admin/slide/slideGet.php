<?php 
    include_once '../../fn.php';
    //获取options表中 轮播图的数据
    $sql = "select * from options where id = 10";
    //执行
    $data = my_query($sql)[0]['value'];

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    //轮播图的数据在数据库中 以json字符串的形式存储的 

    echo $data;
?>