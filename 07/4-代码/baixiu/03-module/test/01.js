// 沙箱模式
(function (window) {

    var num = 100;
    var obj = {
        name: '狗蛋',
        age: 18,
        sing: function () {
            alert('左手右手一个慢动作！');
        }
    }
    
    //暴露数据
    window.obj = obj;

})(window);