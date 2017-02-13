# 富文本

### 前言

    本例子仅借富文本来演示下 POST 上传数据、富文本文件上传，并且会用到上一个文件上传Demo中的类，演示中用是wangEditor富文本(个人推荐,并非打广告)。

<br/>

### 编写路由

```php
...
    "/form"                                  => [
        "POST" => "Form@test"
    ]
...    
```

<br/>

### 控制器

- /App/Controllers/Form.php

```php
<?php
namespace App\Controllers;

class Form
{
    /**富文本测试
     *
     * @param string $title 标题
     * @param string $content 内容
     */
    public function test($title, $content)
    {
        response(200, ["status" => 200, "date" => ["request_title" => $title, "request_content" => $content]]);
    }
}
```

<br/>

### 页面

- index.html (例子是在富文本官方给的代码例子的基础上编辑，附带的静态文件请在[这里下载](https://github.com/wangfupeng1988/wangEditor/releases)，调试结果请在控制台中查看)

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>wangEditor</title>
    <link rel="stylesheet" type="text/css" href="./dist/css/wangEditor.min.css">
    <style type="text/css">
        #div1 {
            width: 100%;
            height: 500px;
        }
    </style>
</head>
<body>
    <div id="div1">
        <p>请输入内容...</p>
    </div>
    <button id="btn1">submit</button>

    <script type="text/javascript" src="./dist/js/lib/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="./dist/js/wangEditor.min.js"></script>
    <script type="text/javascript" src="./dist/js/test.js"></script>
    <script type="text/javascript">
        $(function () {
            var editor = new wangEditor('div1');
            editor.config.uploadImgUrl = 'http://localhost/frame_test/public/upload';
            editor.config.uploadImgFileName = "file";
            editor.create();

            $('#btn1').click(function () {
                // 获取编辑器区域完整html代码
                var html = editor.$txt.html();

              	//这里的网址请根据自己情况来修改，具体使用方法请参考再下面的Js源码
                fetchApi("http://localhost/frame_test/public/form", "POST", {title:"Test Editor",content:html}).then(function (data){
                    console.log(data);
                });
            });
        });
    </script>
</body>
</html>
```

<br/>

### 最后说两句

    声明：该例子的代码仅提供参考，未能达到产品级别。若某些地方存在错误，请大侠指出，谢谢。