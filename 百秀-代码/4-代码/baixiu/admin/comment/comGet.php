<?php 
    include_once '../../fn.php';
    //根据前端传递页码，和每页数据条数，返回对应页码的数据
    $page = $_GET['page'];
    $pageSize = $_GET['pageSize'];

    //截取的起始索引 = （页码-1）* 每页数据条数
    $start = ($page - 1) * $pageSize;

    $sql = "select comments.*, posts.title from comments   
    join posts on comments.post_id = posts.id      
    limit $start, $pageSize";    
    
    //执行sql
    $data = my_query($sql);

    //返回 json数据
    echo json_encode($data);
    
?>