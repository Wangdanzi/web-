<?php 
    include_once '../../fn.php';
    //根据前端传递id 进行删除
    $id = $_GET['id'];
    //准备sql
    $sql = "delete from comments where id in ($id)";
    //执行
    my_exec($sql);
    //删除后数据会有什么变化？
    //删除后数据库的数据总数会发生改变， 会导致前端分页标签的个数改变
    //为了方便前端，及时的更新分页标签页码， 每次删除完成后，返回删除后数据库剩余有效评论总数

    $sql1 = "select count(*) as 'total' from comments  join posts where comments.post_id = posts.id;";

    //执行
    $data = my_query($sql1)[0];

    //返回剩余的评论总数 
    echo json_encode($data);

?>