<?php 
    include_once '../../fn.php';
    // 根据前端传递id进行删除 
    $id = $_GET['id'];
    //sql
    $sql = "delete from categories where id = $id";
        
    //执行
    if(my_exec($sql)) {
        echo 'success!';
    } else {
        echo 'error!';
    }

?>