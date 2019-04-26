<?php 
    include_once '../../fn.php';
    //返回分类的全部数据
    $sql = "select * from categories";

    //执行
    $data = my_query($sql);

    //返回json格式数据
    echo json_encode($data);
?>