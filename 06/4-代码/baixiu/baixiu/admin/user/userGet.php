<?php 
    include_once '../../fn.php';
    //获取所有用户信息，返回
    $sql = "select * from users";
    //执行
    echo json_encode(my_query($sql));
?>