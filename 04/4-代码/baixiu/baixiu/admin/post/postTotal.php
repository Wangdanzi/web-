<?php 

    //返回有效文章总数的接口
    // 查询有效文章的总数 
    // 有效文章： 1文章的作者必须存在 2-文章必须有分类    
    include_once '../../fn.php';

    //准备sql
    $sql = "select count(*) as total from posts 
    join users on posts.user_id = users.id 
    join categories on posts.category_id = categories.id";

    //执行
    echo json_encode( my_query($sql)[0] );
?>