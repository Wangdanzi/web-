<?php 
    // 根据前端id，返回对应id文章数据
    include_once '../../fn.php';
    //获取id
    $id = $_GET['id'];
    //准备sql
    $sql = "select * from posts where id = $id";
    //执行 
    $data = my_query($sql)[0];


    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    echo json_encode($data);

?>