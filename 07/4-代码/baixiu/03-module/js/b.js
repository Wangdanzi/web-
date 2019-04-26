define([], function () {

    console.log('我是模块b');
    var  obj = {
        name: 'chunge',
        hobby: 'bug'
    }

    //暴露数据给外界 
    //直接使用return 设置 导出项 
    return  obj;
})