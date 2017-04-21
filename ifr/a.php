Js代码
/*主页面A*/
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>主页面A</title>
    <script type="text/javascript">
        function init(){
            document.domain = 'bai.sohu.com';
            alert('我是主框架，嵌入了第三方应用IframeB,下面开始加载应用');
            var iframeTag = document.getElementById('frameB'),
                iframeSrc = 'http://test.com/iframePage.html';

            iframeTag.src = iframeSrc;
            iframeTag.style.display = 'block';
        };

        function callback(h){
            var iframeB = document.getElementById('frameB');
            alert('IframeC调用我（主框架）接口，把IframeB的高度传给我，具体值是：' + h);
            iframeB.style.height= h + 10 + 'px';
            iframeB.src += '#'+ h
        };
    </script>
</head>
<body onload="init();">
<p>我是主页框架，我的域是：bai.sohu.com</p>
<iframe id="frameB" style="display:none;"></iframe>
</body>
</html>

iframeB（iframePage.html）的源码
复制代码 代码如下:

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>iframeB</title>
</head>
<body onload="init();">
<p style="height:500px;">我是三方应用，我的域是：test.com</p>
<iframe id="frameC" style="height:1px;width:1px;display:none;"></iframe>
</body>
</html>
<script type="text/javascript">
    function init(){
        alert('我是第三方App，下面开始创建和主框架同域的通信通道IframeC,并设置它的src，用#号传递高度值');

        var iframeTag = document.getElementById('frameC'),
            iframeSrc = 'http://bai.sohu.com/iframePageC.html#',
            pageHeight = document.documentElement.scrollHeight || document.body.scrollHeight;

        iframeTag.src = iframeSrc + pageHeight;
        iframeTag.style.display = 'block';

        window.setTimeout(function(){
            alert('主页面设置我（IframeB）的src，通过Hash（#）给我传递它收到的高度：' + location.hash);
        },2000);
    };
</script>

<script type="text/javascript">
    document.domain = 'bai.sohu.com';
    alert('我（IframeC）收到iframeB通过参数（#）给我传递高度值，我现在调用主页面方法去设置IframeB的高度');
    top.callback(window.location.href.split('#')[1]);
</script>