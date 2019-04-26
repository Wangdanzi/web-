    //配置路径
    require.config({
        //基础路径：
        baseUrl: '/study/baixiu/04-baixiu-module/assets/vendors/',
        //别名
        paths: {
          jquery:'jquery/jquery',
          template: 'template/template-web',
          moment: 'moment/moment',
          wangEditor: 'wangEditor/wangEditor',
          pagination: 'pagination/jquery.pagination',
          bootstrap: 'bootstrap/js/bootstrap',
          post: 'post'
        },
        shim: {  //给第三方不支持模块的插件 绑定 依赖项 
          bootstrap: {
            deps: ['jquery'] //指定依赖项
          },
          pagination: {
            deps: ['jquery']  //指定依赖项
          }
        }
      });