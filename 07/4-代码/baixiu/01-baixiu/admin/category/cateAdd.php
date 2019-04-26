<?php 
    include_once '../../fn.php';
    //获取前端传递 分类数据，添加到数据库中
    $name = $_POST['name'];
    $slug = $_POST['slug'];

    //准备sql
    $sql = "insert into categories (name, slug) values ('$name', '$slug')";

    echo $sql; 

    //执行
    if(my_exec($sql)) {
        echo 'success!';
    } else {
        echo 'error!';
    }
?>