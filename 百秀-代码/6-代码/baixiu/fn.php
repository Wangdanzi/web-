<?php 
    header('content-type:text/html;charset=utf-8');
    // 封装执行查询语句（select） 和非查询(增删改)语句方法
    // 非查询：返回true false
    // 查询： 需要对查询结果进行返回处理
    define('HOST', '127.0.0.1');
    define('UNAME', 'root');
    define('PWD', 'root');
    define('DB', 'z_baixiu');

    // 1-连接数据库  mysqli_connect();
    // 2-准备sql语句(php中准备的sql)
    // 3-将sql语句传递给数据库执行  mysqli_query();
    // 4-分析执行结果
    // 5-关闭数据库 mysqli_close(); 

        
    //1-封装执行非查询语句方法,返回执行成功或者失败
    function my_exec($sql) {       
       //1-连接数据库
       $link =  mysqli_connect(HOST, UNAME, PWD, DB);  //失败 --> false  成功 --> 数据库连接对象
       //判断数据库是否连接成功，连接失败到此结束
       if(!$link) {
           echo '数据库连接失败!';
           return false;   
       }

       //2-执行sql 
       $isSuccess = mysqli_query($link, $sql);

       if(!$isSuccess) {
           echo '操作失败';
       }

       //3-关闭数据库
       mysqli_close($link);
       //4-返回执行结果
       return $isSuccess;
    }

    // $sql = "delete from posts where id = 63";

    // my_exec($sql);

    //2-封装执行查询语句的方法
    // 执行成功 ，返回查询到数据 （二维数组）
    // 执行失败 ： false 
    function my_query($sql) {
        //1-连接数据库
        $link =  mysqli_connect(HOST, UNAME, PWD, DB);  //失败 --> false  成功 --> 数据库连接对象
        //判断数据库是否连接成功，连接失败到此结束
        if(!$link) {
            echo '数据库连接失败!';
            return false;   
        }

        //2-执行sql语句
        //mysqli_query()执行查询语句 成功返回结果集 失败false 
        $result = mysqli_query($link, $sql);

        //如果查询结果出错 或者结果集行数为 0 ,说明没有数据 
        if(!$result || mysqli_num_rows($result) == 0 ) {
            echo '未查询到数据！';
            //关闭数据库
            mysqli_close($link);
            return false;
        }

        //如果有数据则保持数据
        while ( $row =  mysqli_fetch_assoc($result) ) {
            $data[] = $row; //将获取关联数组的数据追加到 $data中 
        }
        //关闭数据库
        mysqli_close($link);
        return $data; //返回的是二维数组
    }

    // $sql = "select * from users";

    // $data = my_query($sql);

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';

    function isLogin() {
        //访问次页面之前，判断用户之前是否登录过，
        // 如果没有登录跳转到登录页，
        //1-登录过的用户，在浏览器cookie中有session ID  
        //2-判断 浏览器的cooke的session 和服务器的是否一致 ，一致则正常浏览
        if(empty($_COOKIE['PHPSESSID'])) {
            //没有登录过程，去登录
            header('location: ./login.php');
        } else {
            //验证sessionID是否一致
            session_start(); //重启session文件
            if(empty($_SESSION['user_id'])) { //会根据浏览器传递session去找对文件的数据
                //sessionID有问题
                header('location: ./login.php');
            }
        }
    }
?>