<?php 
    include_once '../../fn.php';
    //根据前端传递页码 和每页数据条数 返回对应页面的数据
   
    //获取前端传递数据
    $page = $_GET['page'];
    $pageSize = $_GET['pageSize'];

    //起始索引
     //分页起始索引 = (页面 -1) * 每页的数据条数 "
    $start = ($page -1) * $pageSize;
    //准备sql
    $sql = "select posts.*, users.nickname, categories.name from posts 
            join users  on posts.user_id = users.id  -- 联合用户表查用户名 
            join categories on posts.category_id = categories.id -- 联合 分类表查询分类名称
            order by posts.id  desc   -- 根据文章id进行排序  默认升序  desc 降序
            limit $start, $pageSize  -- 截取指定页码的数据";
    
    //执行

    $data = my_query($sql);

    //返回json格式的数据
    echo json_encode($data);
?>