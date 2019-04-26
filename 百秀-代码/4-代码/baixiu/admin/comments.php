<?php 
  include_once '../fn.php';
  isLogin();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/vendors/pagination/pagination.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="login.html"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch pull-left" style="display: none">
          <button class="btn btn-info btn-sm btn-approveds">批量批准</button>         
          <button class="btn btn-danger btn-sm btn-dels">批量删除</button>
        </div>

      <!-- 分页容器 -->
      <div class="page-box pull-right"></div>

      </div>
      <!-- <input type="range" name="" id=""> -->
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <!-- 全选 -->
            <th class="text-center" width="40"><input class="th-chk" type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-info btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>        
        </tbody>
      </table>

    </div>
  </div>
  <!-- 给页面添加标记 -->
  <?php $page = 'comments' ?>
  <!-- 侧边栏 -->
  <?php include_once './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script>NProgress.done()</script>
  <script type="text/template" id="tmp" >
    {{ each list v i }}
      <tr>
        <td class="text-center" data-id={{v.id}}><input class="tb-chk" type="checkbox"></td>
        <td>{{ v.author }}</td>
        <td>{{ v.content.substr(0, 20) + '...' }}</td>
        <td>《{{ v.title }}》</td>
        <td>{{ v.created}}</td>
        <td>{{ state[v.status] }}</td>
        <td class="text-right" data-id={{v.id}}>
              {{ if v.status == 'held' }}
              <a href="javascript:;" class="btn btn-info btn-xs btn-approved">批准</a>
              {{ /if }}
              <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
        </td>
      </tr>
    {{ /each }}
  </script>
  <script>
    var currentPage = 1; //存放当前页
    //待审核（held）/ 准许（approved）/ 拒绝（rejected）/ 回收站（trashed）

    var state = {
      held: "待审核",
      approved: "准许",
      rejected: "拒绝",
      trashed: "回收站"
    }
    // var str = 'held';
    // state['held']; 
    //0-封装 从后台获取指定页面的数据，并渲染的功能
    function render(page) {
      $.ajax({
        url: './comment/comGet.php',
        data: {
          page: page || 1,
          pageSize: 10
        },
        dataType: 'json',
        success: function (info) {
          console.log(info);      
          var obj = {
            list: info,
            state: state
          }  
          //生成结构 渲染table中
          $('tbody').html( template('tmp', obj));    
          //重置全选按钮 和 批量操作按钮
          $('.th-chk').prop('checked', false);
          $('.btn-batch').hide();    
        }
      })
    }

    //1-页面加载完成后，显示第一屏数据
    render();

    //2-生成分页标签 
    //封装一个生成分页标签的方法
    //获取后台有效的评论的总数
    //根据总数生成分页标签
    function setPage(page) {
      // 获取后台有效的评论的总数
      $.ajax({
        url: './comment/comTotal.php',
        dataType: 'json',
        success: function (info) {
          console.log(info);        
          //生成分页标签
          $('.page-box').pagination(info.total,{
            prev_text: '上一页',
            next_text:  '下一页',
            num_display_entries: 5, //连续主体个数
            num_edge_entries: 1,//首尾显示个数
            current_page: page - 1 || 0, //默认选中第一页
            load_first_page: false, //页面初始化是 不执行callback,
            callback: function (index) {
              //index 是页面索引值 ，比页码小1
              console.log(index + 1);
              //渲染当前分页标签对应的页面
              render(index + 1);
              //点击分页标签时，记录最新当前页
              currentPage = index + 1;
            }
          });  
        }
      })
    }

    //3-调用生成分页的方法
    setPage();

    //4-批准评论
    //1-前端点击批准按钮，获取数据对应id 
    //2-后他获取id,根据id修改对应的数据
    //3-重新渲染前端页面，看到批准后的效果

    //由于批准按钮是通过模板引擎动态渲染出来的，通过下面写法无法绑定到事件
    // $('.btn-approved').click(function () {
    //   alert(1);
    // })

    //对于动态生成元素，绑定事件推荐使用事件委托实现
    //对于还没有生成的元素，可以将事件委托给一个已经存在父元素，将事件绑定给父元素，将来有子元素触发
    //语法 $(父元素).on(事件类型， 子元素， function () {})
    $('tbody').on('click', '.btn-approved', function () {
      var id = $(this).parent().attr('data-id');   //prop(); 用于 checked  selected disabled
      //alert(id);
      $.ajax({
        url: './comment/comApproved.php',
        data: {id: id},
        success: function (info) {
          console.log(info);
          //重新渲染当前页
          render(currentPage);
        }
      })
    })
    

    //5-删除评论 
    //1-点击删除按钮，获取数据id
    //2-后台根据id进行删除
    //3-删除完成后，重新渲染当前页，看到删除效果
    $('tbody').on('click', '.btn-del', function () {
      var id = $(this).parent().attr('data-id');
      //将id传给后台进行删除
      $.ajax({
        url: './comment/comDel.php',
        data: {id: id},
        dataType: 'json',
        success: function (info) {
          console.log(info);
          //要判断当前页currentPage值是否大于数据库中数据最大页码
          //根据服务器的剩余的数据总数，推算出数据库最大页码
          var maxPage = Math.ceil(info.total/10);

          if(currentPage > maxPage) {
            currentPage = maxPage;
          }
          //重新渲染当前页
          render(currentPage); //46 ---> 45
          //重新生成分页标签,选中当前页
          setPage(currentPage);          
        }
      })
    })

    //6-全选功能
    //1-小复选框 的选中状态和 全选按钮一致
    //2-全选按钮选中，批量按钮 显示，否则隐藏
    // input.onchange = function () { }
    //当表单状态发生改变时触发  
    $('.th-chk').change(function () {
      var value = $(this).prop('checked');
      //小复选框 的选中状态和 全选按钮一致
      $('.tb-chk').prop('checked', value);
      //全选按钮选中，批量按钮 显示，否则隐藏
      if(value) {
        $('.btn-batch').show(); //显示
      } else {
        $('.btn-batch').hide(); //隐藏
      }
    })


    //7-多选功能
    //1-如果有小复选框选中，批量按钮出现
    //2-如果所有的小复选框全部选中，则全选按钮选中
    $('tbody').on('change', '.tb-chk', function () {
      
      //1-如果有小复选框选中，批量按钮出现
      //$('.tb-chk:checked').length 被选中复选框的个数
      if ($('.tb-chk:checked').length > 0) {
        $('.btn-batch').show();
      } else {
        $('.btn-batch').hide();
      }

      //2-如果所有的小复选框全部选中，则全选按钮选中
      //如果选中复选框个数 == 页面中所有小复选框的个数 
      if ( $('.tb-chk').length  == $('.tb-chk:checked').length ) {
        //全选
        $('.th-chk').prop('checked', true);
      } else {
        $('.th-chk').prop('checked', false);
      }
      
    })


    //8-获取被选中复选框对应数据的id
    function getId() {
      var ids = []; //存放获取的id
      //console.log( $('.tb-chk:checked'));      
      $('.tb-chk:checked').each(function (i, e) {
        ids.push( $(e).parent().attr('data-id'));
      })
      // console.log(ids.join());      
      return ids.join();
    }

    //9-批量批准
    $('.btn-approveds').click(function () {
      var ids = getId();
      //将id传递给后台
      $.ajax({
        url: './comment/comApproved.php',
        data:{id: ids},
        success: function () {
          //重新渲染当前页
          render(currentPage);
        }
      })
    })

    //10-批量删除
    $('.btn-dels').click(function () {
      //获取被选中的id
      var ids = getId();
      //将id传递给后台 进行删除
      $.ajax({
        url:'./comment/comDel.php',
        data:{id: ids},
        dataType: 'json',
        success: function (info) {
           console.log(info);
           //判断当前是否大于数据库中最大的页吗
           var maxPage = Math.ceil(info.total/10);
           if(currentPage > maxPage) {
             currentPage = maxPage;
           }
           //重新渲染当前页
           render(currentPage);
           //重新生成分页笔标签
           setPage(currentPage);          
        }
      })
    })



  </script>
</body>
</html>
