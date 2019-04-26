<?php 
    include_once '../../fn.php';

    //根据前端传递id,删除对应数据 
    $id = $_GET['id'];
    //根据id进行删除
    $sql = "delete from posts where id = $id";
    //执行
    my_exec($sql);

    //删除之后数据总条数发生变化，分页的页吗也会随之变化，返回删除后，数据库剩余的数据总数
    //准备sql
    $sql1 = "select count(*) as total from posts 
    join users on posts.user_id = users.id 
    join categories on posts.category_id = categories.id";

    //执行
    echo json_encode( my_query($sql1)[0] );
?>