<?php 
    include_once '../../fn.php';
    //返回有效的评论的总数 （用于实现分页功能）
    //评论对应文章 是存在的
    $sql = "select count(*) as 'total' from comments  join posts where comments.post_id = posts.id;";

    //执行
    $data = my_query($sql)[0];

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';

    // {"total": 498}
    // my_query($sql)[0]['tota;']   498

    echo json_encode($data);
?>