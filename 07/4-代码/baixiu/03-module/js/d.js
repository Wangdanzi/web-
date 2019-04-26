define(['./c'], function (mc) {
    console.log('我是d模块');
    //在d模块中获取c导出项 
    console.log(mc);   
    return 'aa'; 
})