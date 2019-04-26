<?php 
    include_once '../../fn.php';
    //获取id 
    $id = $_GET['id'];
    //sql
    $sql = "select * from categories where id = $id";
    //执行
    $data = my_query($sql)[0];

    //返回
    echo json_encode($data);
?>