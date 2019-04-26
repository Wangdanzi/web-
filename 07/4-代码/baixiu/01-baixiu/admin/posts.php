<?php 
  include_once '../fn.php';
  isLogin();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <!-- 分页的容器 -->
        <div class="page-box pull-right"></div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>        
        </tbody>
      </table>
    </div>
  </div>
    <!-- 给页面添加标记 -->
    <?php $page = 'posts' ?>
  <!-- 侧边栏 -->
  <?php include_once './inc/aside.php' ?>
  <!-- 引入模态框 -->
  <?php include_once './inc/edit.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script src="../assets/vendors/moment/moment.js"></script>
  <script src="../assets/vendors/wangEditor/wangEditor.js"></script>
  <script>NProgress.done()</script>
  <!-- 渲染文章数据的模板 -->
  <script type="text/template" id="tmp">
    {{ each list v i }}
        <tr>
            <td class="text-center" data-id={{v.id}}><input class="tb-chk" type="checkbox"></td>
            <td>{{ v.title }}</td>
            <td>{{ v.nickname }}</td>
            <td>{{ v.name }}</td>
            <td class="text-center">{{ v.created }}</td>
            <td class="text-center">{{ state[v.status] }}</td>
            <td class="text-center" data-id={{v.id}}>
              <a href="javascript:;" class="btn btn-default btn-xs btn-edit">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
            </td>
          </tr>   
    {{ /each }}
  </script>
  <!-- 分类的模板 -->
  <script type="text/template" id="tmp-cate">
    {{ each list  v  i }}
        <option value="{{ v.id }}">{{ v.name }}</option>
    {{ /each }}
  </script>

  <!-- 状态的模板 -->
  <script type="text/template" id="tmp-state">
    {{ each obj v k }}
      <option value="{{ k }}">{{ v }}</option>
    {{ /each }}
  </script>
  <script src="../assets/vendors/post.js"></script>
  <script>
    var currentPage = 1; //记录当前页
    // 草稿（drafted）/ 已发布（published）/ 回收站（trashed）
    var state = {
      drafted: '草稿',
      published: '已发布',
      trashed: '回收站'
    }
    //  state['drafted']
     //1-获取数据，并渲染
     function render(page) {
       $.ajax({
         url: './post/postGet.php',
         data: {
           page: page || 1,
           pageSize: 10
         },
         dataType: 'json',
         success: function (info) {
           console.log(info);   //info是数组  
           //包装info成对象
           var obj = {
             list: info,
             state: state
           }      
           //绑定数据和模板
           $('tbody').html( template('tmp', obj));
          //  $('tbody').append() 在tbody内部的后面追加元素
         }
       })
     }
     //2-获取第一屏的数据
     render();

     //3-封装生成分页标签方法
     function setPage(page) {
       //1-获取后台有效文章总数
       //2-根据文章总数生成分页标签
       $.ajax({
         url: './post/postTotal.php',
         dataType:'json',
         success: function (info) {
           console.log(info);       
           //生成分页标签
           $('.page-box').pagination(info.total, {
             prev_text: '上一页',
             next_text: '下一页',
             current_page: page - 1 || 0, //选中的当前页码
             num_display_entries: 5, //连续主体的个数
             num_edge_entries: 1, //首尾显示个数
             load_first_page: false, //页面初始化是不执行回调函数
             callback: function (index) { //分页标签被点击是执行
                //渲染当前选中的页面
                render(index + 1);
                //记录当前页
                currentPage = index + 1;
             }
           });    
         }
       })
     }
     //4-生成分页表
     setPage();

     //5-删除
      // 1. 点击删除按钮 获取该数据id
      // 2. 将id传递给后台，有后台执行删除操作
      // 3. 操作完成后， 返回数据库中剩余数据总条数（数据总条数发生变化，分页的页吗也会随之变化）
      // 4. 刷新页面数据，看到删除后效果
      $('tbody').on('click', '.btn-del', function () {
        var id = $(this).parent().attr('data-id');
        //将id传递给后台进行删除
        $.ajax({
          url: './post/postDel.php',
          data: {id: id}, 
          dataType: 'json',
          success: function (info) {
            console.log(info);
            //判断当前页是否大于数据库最大页码
            var maxPage = Math.ceil(info.total / 10);
            if(currentPage > maxPage) {
              currentPage = maxPage;
            }
            //重新渲染当前页
            render(currentPage);
            //重生成分页标签    
            setPage(currentPage);        
          }
        })
      })


      //6-准备模态框的数据
      // 在模态框中准备基本的数据
      // 填充分类下拉列表
      $.ajax({
        url:'./category/cateGet.php',       
        dataType: 'json', //JSON.parse();
        success: function (info) {
          console.log(info);    
          //将数据渲染到页面上
          $('#category').html( template('tmp-cate', {list: info}) );
        }
      })
      // 填充状态列表的
      //文章状态的数据
      var state = {
        drafted: '草稿',
        published: '已发布',
        trashed: '回收站'
      }

      //绑定数据和模板
      var  str = template('tmp-state', {obj: state});
      $('#status').html(str);      
      // 别名同步
      $('#slug').on('input', function () {
        $('#strong').text($(this).val() || 'slug');
      })
      // 本地预览
      $('#feature').change(function () {
        //获取第一个选中文件
        var file = this.files[0];
        //获取url
        var url = URL.createObjectURL(file);
        //显示
        $('#img').attr('src', url).show();
      })
      // 时间格式化
      $('#created').val(moment().format('YYYY-MM-DDTHH:mm'));

      // 准备富文本编辑器
      var E = window.wangEditor;
      var editor = new E('#content-box');
      //监听富文本编辑器内容变化
      editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            //html 是当前富文本编辑器内容
            $('#content').val(html);
        }
      editor.create();



      //7-点击编辑按钮，获取对应文章数据，填充在模态框中
      $('tbody').on('click', '.btn-edit', function () {
        //获取id
        var  id = $(this).parent().attr('data-id');
        //请求数据
        $.ajax({
          url: './post/postGetOne.php',
          data: {id: id},
          dataType: 'json',
          success: function (info) {
             console.log(info);     
             //模态框显示
             $('.edit-box').show();   
              //向模态框中填充数据   
              // 标题
              $('#title').val(info.title);
              // 别名(strong标签也要修改)
              $('#slug').val(info.slug);
              $('#strong').text(info.slug);
              // 图像（用img标签显示）
              $('#img').attr('src', '../' + info.feature).show();    
              // 时间设置(注意格式)
              $('#created').val(moment(info.created).format('YYYY-MM-DDTHH:mm'));
              // 文章内容设置(同时设置textarea  和 富文本编辑器 )
              //富文本编辑器
              editor.txt.html(info.content);
              $('#content').val(info.content);
              // 分类选中(selected)
              // 不需要填充数据，只需找到指定数据，被选中即可selected 
              $('#category option[value='+ info.category_id+']').prop('selected', true);
              // $('input[type="text"]')
              // 状态选中(selected)
              $('#status option[value=' + info.status  + ']').prop('selected', true);
              // 设置id(更新数据是需要根据id进行更新)
              $('#id').val(info.id);

          }
        })
      })


      //8-放弃修改，模态框隐藏
      $('.btn-cancel').click(function () {
        $('.edit-box').hide();
      })

      //9-点击修改按钮，获取表单数据，提交给后台进行更新（ajax)
      $('.btn-update').click(function () {
        //获取表单数据
        // 表单序列化 serialize() 
        // FromData  管理表单的对象
        //注意点： 1-必须post方式 2-不需要手动设置请求头，浏览器会自动设置一个合适请求头
        var formData = new FormData( $('#editForm')[0] );

        //提交给服务器
        //问题出现的原因： 在jqeruy中如果是post方式 $.ajax会设置请求头， 但是formData不要 
        $.ajax({
          type: 'post',
          url: './post/postUpdate.php',
          data: formData,
          contentType: false, //告诉jq的ajax 不要去设置请求头
          processData: false, //告诉jq的ajax  不用转换数据了 ，此时数据有formData进行管理
          success: function(info) {
            console.log(info);
            //隐藏模态框
            $('.edit-box').hide();
            //重新渲染当前页面
            render(currentPage);
          }
        })
      })





  </script>
</body>
</html>
