<?php
    include_once '../../fn.php';
    // 根据前端传递数据，根据id进行修改
    $id = $_GET['id'];
    $name = $_GET['name'];
    $slug = $_GET['slug'];

    //根据id进行修改
    $sql = "update categories set name = '$name', slug = '$slug' where id = $id";

    //执行
    if(my_exec($sql)) {
        echo 'success!';
    } else {
        echo 'error!';
    }
?>