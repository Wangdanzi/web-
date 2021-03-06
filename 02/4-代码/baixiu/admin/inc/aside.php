<?php 
  echo $_SESSION['user_id'];
  //获取当前登录用户id
  $id = $_SESSION['user_id'];
  //获取当前用户的信息
  $sql = "select * from users where id = $id";
  //查询
  $data = my_query($sql)[0];

  // echo '<pre>';
  // print_r($data);
  // echo '</pre>';

  //判断当前页面是否是 文章模块 
  //if ($page == 'posts' || $page == 'post-add' || $page == 'categories') {}
  $isPost = in_array($page, ['posts', 'post-add', 'categories']);
  //判断当前页面是否属于设置模块
  $isSet = in_array($page , ['settings', 'slides', 'nav-menus']);
?>

<div class="aside">
    <div class="profile">
      <img class="avatar" src="../<?php echo $data['avatar'] ?>">
      <h3 class="name"><?php echo $data['nickname'] ?></h3>
      <p style="color: red"><?php echo $page ?></p>
    </div>
    <ul class="nav">
      <!-- 高亮的导航 添加active类名  -->
      <!-- 仪表盘 -->
      <li class="<?php echo $page == 'index1'? 'active': '' ?>">
        <a href="index1.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <!-- 文章 -->
      <!-- 大li的active 实现自己高亮 -->
      <li class="<?php echo $isPost?'active': '' ?>">
      <!-- a标签去掉 collapsed类名，箭头向下 -->
        <a href="#menu-posts" data-toggle="collapse"  class="<?php echo $isPost?'':'collapsed' ?>" >
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <!-- ul的in类名展开列表 -->
        <ul id="menu-posts" class="collapse <?php echo $isPost ? 'in': '' ?>">
          <li  class="<?php echo $page == 'posts'? 'active': '' ?>"><a href="posts.php">所有文章</a></li>
          <li  class="<?php echo $page == 'post-add'? 'active': '' ?>" ><a href="post-add.php">写文章</a></li>
          <li  class="<?php echo $page == 'categories'? 'active': '' ?>"><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <!-- 评论 -->
      <li  class="<?php echo $page == 'comments'? 'active': '' ?>">
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <!-- 用户 -->
      <li class="<?php echo $page == 'users'? 'active': '' ?>" >
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <!-- 设置 -->
      <li class="<?php echo $isSet? 'active':'' ?>">
        <a href="#menu-settings" class="<?php echo $isSet?'':'collapsed' ?>" data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo $isSet?'in':'' ?>">
          <li  class="<?php echo $page == 'nav-menus'? 'active': '' ?>" ><a href="nav-menus.php">导航菜单</a></li>
          <li  class="<?php echo $page == 'slides'? 'active': '' ?>" ><a href="slides.php">图片轮播</a></li>
          <li  class="<?php echo $page == 'settings'? 'active': '' ?>" ><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>

  <!-- <div class="" ></div>
  <style>
    .box {
      font-family: "宋体";
    }
  </style> -->
  