# 文件上传Demo

### 编写路由

- /App/Config/route.php

```php
...
    "/file"                                    => [
        "POST" => "File@upload"
    ]
...
```

<br/>

### 控制器

- 一个文件上传的程序代码，如果混到控制器里面的话，那可能会显得代码有点“凌乱”。为了让代码让人看得更舒服，我们可以考虑写成一个单独的类，放到`/App/Lib 文件夹`里面，在控制器里面调用即可。
- 文件上传类，我们暂时传两个参数吧，一个是文件的参数名，一个是保存的路径(选填，默认值是/public)。创建一个类 /App/Lib/Upload.php

```php
<?php
namespace App\Lib;


class Upload
{
    private $file_info;

    private $file_suffix;

    private $file_save_path;

    private $allow_file_size = 6666;

    private $allow_file_suffix = ['png', 'gif', 'jpeg', 'jpg', 'txt'];

    private $default_file_path = __ROOT__ . "/public";


    public static function file($uploadFileField, $file_save_path = '')
    {
        return (new Upload($uploadFileField, $file_save_path))->uploadFile();
    }


    public function __construct($uploadFileField, $file_save_path)
    {
        $this->file_info = $_FILES[ $uploadFileField ];

        $this->file_suffix = $this->getFileSuffix($this->file_info["name"]);

        $this->file_save_path = $this->getFileSavePath($file_save_path);
    }


    public function uploadFile()
    {
        if (!$this->isValidFile()) {
            return false;
        }

        $save_file_name = $this->file_save_path . '/' . $this->getNewFileName();

        if (!$this->moveFileToSavePath($save_file_name)) {
            return false;
        }

        return $save_file_name;
    }


    protected function getFileSuffix($file_name)
    {
        $pieces = explode(".", $file_name);

        return end($pieces);
    }


    private function isValidFile()
    {
        return $this->isValidSize() && $this->isValidSuffix();
    }


    private function isValidSuffix()
    {
        return in_array($this->file_suffix, $this->allow_file_suffix);
    }


    private function isValidSize()
    {
        return $this->file_info['size'] <= $this->allow_file_size;
    }


    private function getNewFileName()
    {
        $pre_file_name = md5(time() . $this->file_info['tmp_name']);

        return $pre_file_name . '.' . $this->file_suffix;
    }


    private function getFileSavePath($file_path)
    {
        return $file_path ?: $this->default_file_path;
    }


    private function moveFileToSavePath($save_file_name)
    {
        return move_uploaded_file($this->file_info['tmp_name'], $save_file_name);
    }
}
```

- /App/Controllers/File.php

```php
<?php
namespace App\Controllers;

use App\Lib\Upload;

class File
{
    /**上传文件
     *
     * @group Upload
     *
     * @param file $file 文件字段
     *
     * @return status:状态码 data:文件路径 errorMsg:错误信息
     * @example 文件格式有误 {"status":500,"errorMsg":"The file format is wrongful."}
     * @example 成功 {"status":200,"data":"File Path Is E:\\phpstudy\\WWW\\frame_test\/public\/a3076d8eb2f2ef500bbd87869d384892.jpg"}
     */
    public function upload($file = "file")
    {
      	# $file参数对应文件上传时对应的键名(name)
        if ($file_path = Upload::file($file)) {
            response(200, ["status" => 200, "data" => "File Path Is $file_path"]);
        } else {
            response(200, ["status" => 500, "errorMsg" => "The file format is wrongful."]);
        }
    }
}    
```

<br/>

### 调试

- `/api/list` 中调试
- 写个页面调试 (调试结果请在控制台中查看)

```html
<!DOCTYPE doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <script type="text/javascript" src="./fetch.js"></script>
        <script type="text/javascript">
            function up(){   
              	//这里的网址请根据自己情况来修改，具体使用方法请参考再下面的Js源码
                fetchApi("http://localhost/frame_test/public/file", "POST", "#upload", 1).then(function(data){
                        console.log(data);
                    }
                );
            }
        </script>
    </head>
    <body>
        <form id="upload" name="fileinfo">
            <input name="file" type="file"/>
            <input type="button" value="提交" onclick="up()">
        </form>
    </body>
</html>
```

- fetch.js 

```javascript
/**fetchGetApiResp
 *
 * @param url    apiUrl
 * @param method HTTP_METHOD(exp:POST,GET,PUT...), default:"GET"
 * @param body   json:{column:content,col2:content2}, form file(exp:uploadFile):"#form_id" or ".form_class"
 * @param isFile true or false, default:false
 * @example GET  fetchApi("http://testapi.wangyuan.info/v1/logout").then(function (data){......})
 * @example POST fetchApi("http://testapi.wangyuan.info/v1/output", "POST", {a:abc,b:gg}).then(function (data){......})
 * @example FILE fetchApi("http://testapi.wangyuan.info/v1/uploadFile", "POST", "#form_id", 1).then(function (data){......})
 */
function fetchApi(url, method, body, isFile) {
    method = method || "GET";
    isFile = isFile || false;

    headers = {"authentication": localStorage.token};
    if (isFile) {
        body = new FormData(document.querySelector(body));
    } else {
        headers["Content-Type"] = "json";
        body = (method == "GET") ? null : JSON.stringify(body);
    }

    var myInit = {
        method: method,
        headers: headers,
        body: body
    };
    return fetch(url, myInit)
        .then(function (response) {
            return response.json();
        })
}

function login(username, password) {
    return fetchApi("http://localhost/frame_test/public/login/" + username + "/" + password).then(function (data) {
        if (data.status == 200) {
            localStorage.token = data.authentication;
        }

        return data;
    });
}

function logout() {
    return fetchApi("http://localhost/frame_test/public/logout").then(function (data) {
        if (data.status == 200) {
            localStorage.token = null;
        }

        return data;
    });
}
```

<br/>

### 跨域上传

- 若是跨域上传则要在config.php配置允许跨域的源地址

```php
    /**
     * 允许跨域的源地址，默认为允许全部
     */
    'origin'          => "*",    

	#'origin'		 => "http://local.zeffee.com"
```

<br/>

### 最后说两句

    声明：该例子的代码仅提供参考，未能达到产品级别。若某些地方存在错误，请大侠指出，谢谢。