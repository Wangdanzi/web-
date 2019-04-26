<?php 
    include_once '../../fn.php';
    //根据前端传递id，批准对应数据
    $id = $_GET['id'];
    //准备sql  in 语法 可以实现 一对多 的更新
    $sql = "update  comments  set status = 'approved'  where id in ($id)";
    //执行
    if(my_exec($sql)) {
        echo 'success!';
    } else {
        echo 'error!';
    }
?>