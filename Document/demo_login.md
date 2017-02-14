# 登录Demo

### 前言

    为了方便大家对框架有进一步的熟悉，索性写份具体例子，此次以网站基本必用的登录功能为例。写登录功能基本分为四个步骤：`建库建表、编写路由、写控制器、调试` 。

    登录的时候需要账号和密码，采用**GET方式传参登录** ，登录成功后生成一个token，把token和用户信息储存到cache当中并将token返回给用户，用户以后则**用该token来调用接口**。免密码登录一周的话，则在登录时就把token同时储存到cache和数据库中。

<br/>

### 建库建表

- 首先修改连接数据库的配置文件 /App/Config/database.php

```php
return [
    /**
     * 数据库配置
     */
    'database' => [
        'master' => [
            "drive"   => "mysql",
            "host"    => "localhost",
            "dbname"  => "zereri",
            "user"    => "root",
            "pwd"     => "root",
            "charset" => "utf8"
        ],
		
        #演示的为单库，所以slave内容留空
        'slave' => [
        ]
    ]
];
```

- 创建 `zereri` 库，且创建 `user` 表 

```sql
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `token` char(40) DEFAULT NULL,
  `token_expire_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `token` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk
```

    字段为 id 、username、password、token、token_expire_time

    `token`用来进行储存免密码登录时候的口令， `token_expire_time` 则为口令的过期时间。

<br/>

### 编写[路由](./route.md)

- 修改 /App/Config/route.php

```php
return [
    "/api/list"                                => [
        "GET" => "Api@index"
    ],
    "/login/{username}/{password}"             => [
        "GET" => "Login@normalLogin"
    ]
];
```

    GET方式访问 /login/{username}/{password} 则会访问 `/App/Controllers/Login` 类里面的 `normalLogin` 方法。

<br/>

### 控制器

- 控制器中需要连接`user`表，则先创建User [model](./model.md) : /App/Models/User.php

```php
<?php
namespace App\Models;

class User extends Model
{

}
```

- 创建[控制器](./controller.md) /App/Controllers/Login.php

```php
<?php
namespace App\Controllers;

use App\Models\User;

class Login
{
    public function normalLogin($username, $password)
    {
        $token = $this->loginAndSaveInfoToCacheAndReturnToken($username, $password);

        response(200, ["status" => 200, "authentication" => $token]);
    }
  

    private function loginAndSaveInfoToCacheAndReturnToken($username, $password)
    {
        if (!$user = User::where("username", "=", $username)->select()) {
            response(200, ["status" => 404, "errorMsg" => "This account does not exist!"]);
        }

        if ($user[0]["password"] !== $password) {
            response(200, ["status" => 500, "errorMsg" => "Sorry, wrong password, please login again."]);
        }

        $userRandToken = sha1($username . time() . mt_rand(10000, 99999));
        $userData = json_encode($user[0]);
        Cache::set($userRandToken, $userData);

        return $userRandToken;
    }
}    
```

<br/>

### 调试

- 先配置好访问路径，请参考 [**访问机制** ](./visit.md)文档。
- 插入数据至数据库，演示的数据为

```sql
+----+----------+----------+-------+---------------------+
| id | username | password | token | token_expire_time   |
+----+----------+----------+-------+---------------------+
|  1 | zeffee   | 123456   | NULL  | NULL                |
+----+----------+----------+-------+---------------------+
```

- 打开浏览器访问：`http://localhost/login/zeffee/123456`
- 若显示的内容为 `{"status":200,"authentication":"xxxxxxxxxxxxxxxxxxxxxxxxxxx"}`  ，则成功登陆， authentication为调用其他接口的口令

<br/>

### 中场说两句

    至此，一个包含路由、控制器、缓存和模型的登录功能就实现了！ 但是还没有完善， 还要写登出、获取用户信息和免密码登录功能！  (以下内容将会涉及中间件、Api文档生成)

<br/>

### 免密码登录一周

- 免密码登录在前面的登录功能上加一点代码，即将token保存至数据库中，当缓存的token过期后，将查询数据库，再保存至缓存当中。
- 那再改改之前的Login控制器的代码 (为了能自己生产api文档，添加了一些注释，请参考 [**Api文档生成**](./api.md) 文档)

```php
<?php
namespace App\Controllers;

use App\Models\User;

class Login
{
    /**用户登录
     *
     * @group   Login
     *
     * @param string $username 用户名、账号
     * @param string $password 用户密码
     *
     * @return status:状态码
     * @example 成功 {"status":200}
     * @example 账号不存在 {"status":404,"errorMsg":"This account does not exist!"}
     * @example 密码错误 {"status":500,"errorMsg":"Sorry, wrong password, please login again."}
     */
    public function normalLogin($username, $password)
    {
        $this->loginCommon($username, $password);
    }


    /**免密码登录一周
     *
     * @group   Login
     *
     * @param string $username 用户名、账号
     * @param string $password 用户密码
     *
     * @return status:状态码 errorMsg:错误信息
     * @example 成功 {"status":200}
     * @example 账号不存在 {"status":404,"errorMsg":"This account does not exist!"}
     * @example 密码错误 {"status":500,"errorMsg":"Sorry, wrong password, please login again."}
     */
    public function freePasswordLoginForOneWeek($username, $password)
    {
        $this->loginCommon($username, $password, function ($token) use ($username) {
            $this->saveTokenToDb($username, $token);
        });
    }


    private function loginCommon($username, $password, callable $callback = NULL)
    {
        $token = $this->loginAndSaveInfoToCacheAndReturnToken($username, $password);

        if ($callback) {
            $callback($token);
        }

        response(200, ["status" => 200, "authentication" => $token]);
    }


    private function saveTokenToDb($username, $token)
    {
        User::where("username", "=", $username)->update([
            "token"             => $token,
            "token_expire_time" => date("Y-m-d H:i:s", time() + 3600 * 24 * 7)
        ]);
    }


    private function loginAndSaveInfoToCacheAndReturnToken($username, $password)
    {
        if (!$user = User::where("username", "=", $username)->select()) {
            response(200, ["status" => 404, "errorMsg" => "This account does not exist!"]);
        }

        if ($user[0]["password"] !== $password) {
            response(200, ["status" => 500, "errorMsg" => "Sorry, wrong password, please login again."]);
        }

        $userRandToken = sha1($username . time() . mt_rand(10000, 99999));
        $userData = json_encode($user[0]);
        Cache::set($userRandToken, $userData);

        return $userRandToken;
    }
}    
```

- 添加免密码登录的路由

```php
return [
    "/api/list"                                => [
        "GET" => "Api@index"
    ],
    "/login/{username}/{password}"             => [
        "GET" => "Login@normalLogin"
    ],
    "/freePasswordLogin/{username}/{password}" => [
        "GET" => "Login@freePasswordLoginForOneWeek"
    ]
];
```

- 现在访问`http://localhost/api/list` 调试下OK了么？

<br/>

### 获取用户信息

- 获取当前登录的用户信息相当于一个需要认证的接口，需要前面登录的时候返回的 token 作为密钥来换取用户信息，现在可以思考一下，如果其他类似的接口也需要 token 作为身份验证的话，那可能就需要先走一个公用的方法，也可以用[**中间件**](./middleware.md)来实现。
- 因为需要跨域传header . authentication字段, 需要先在config.php设置headers

```php
    /**
     * 调用Api允许携带头部字段名
     */
    'headers'         => [
      	"content-type",
        "authentication"
    ],
```

- 编写中间件 /App/Middles/CheckLogin.php  (可参考 **中间件** 文档)

```php
<?php
namespace App\Middles;

use App\Controllers\Cache;
use App\Models\User;

class CheckLogin implements MiddleWare
{
    public function before($request)
    {
        $token =& $_SERVER["HTTP_AUTHENTICATION"];

        if (!isset($token)) {
            $this->responseErrorTokenMessage();
        }

        if (Cache::has($token)) {
            return true;
        }

        if (!$userData = $this->getUserJsonDataFromDbByToken($token)) {
            $this->responseErrorTokenMessage();
        }

        Cache::set($token, $userData);
    }


    private function getUserJsonDataFromDbByToken($token)
    {
        if ($userData = User::whereAndWhere(["token", "=", $token], ["token_expire_time", ">", date("Y-m-d H:i:s")])->select()) {
            return json_encode($userData[0]);
        }

        return NULL;
    }


    private function responseErrorTokenMessage()
    {
        response(200, ["status" => 502, "errorMsg" => "Token is wrong!"]);
    }


    public function after($request)
    {

    }
}
```

- 添加路由

```php
...
    "/getUserData"                             => [
        "GET" => ["Login@getUserData", "CheckLogin"]
    ]
...
```

- 在 Login 控制器添加代码

```php
    /**获取用户信息
     *
     * @group   Login
     *
     * @header  string authentication 口令认证
     *
     * @return status:状态码 data:用户信息 errorMsg:错误信息
     * @example token无效 {"status":502,"errorMsg":"Token is wrong!"}
     * @example 获取信息成功 {"status":200,"data":{"id":"1","username":"zeffee","password":"123456","token":"05b09921a5032bd2e2bb3db38bda21e0a3433260","token_expire_time":"2017-02-15 00:33:06"}}
     */
    public function getUserData()
    {
        if ($userData = $this->getUserDecodeDataFromCache()) {
            response(200, ["status" => 200, "data" => $userData]);
        }

        response(200, ["status" => 500, "errorMsg" => "Please Login Again!"]);
    }


    private function getUserDecodeDataFromCache()
    {
        $token = $_SERVER["HTTP_AUTHENTICATION"];

        return json_decode(Cache::get($token), true);
    }
```

- 访问`http://localhost/api/list` 进行调试。

<br/>

### 登出

- 登出也是一个需要 token 来进行身份验证的接口，但是前面已经写好了身份验证的中间件，所以直接在路由中调用即可。添加路由：

```php
...
    "/logout"                                  => [
        "GET" => ["Login@logout", "CheckLogin"]
    ]
...
```

- Login控制器添加代码

```php
    /**用户登出
     *
     * @group   Login
     *
     * @header  string authentication 口令认证
     *
     * @return status:状态码 data:用户信息 errorMsg:错误信息
     * @example token无效 {"status":502,"errorMsg":"Token is wrong!"}
     * @example 成功登出 {"status":200,"data":"Successfully logout"}
     */
    public function logout()
    {
        $token = $_SERVER["HTTP_AUTHENTICATION"];
        Cache::delete($token);

        User::where("token", "=", $token)->update([
            "token"             => NULL,
            "token_expire_time" => NULL
        ]);

        response(200, ["status" => 200, "data" => "Successfully logout"]);
    }
```

- 访问`http://localhost/api/list` 进行调试。

<br/>

### 写个页面调试

- index.html (调试结果请在控制台中查看)

```html
<!DOCTYPE doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <script type="text/javascript" src="./fetch.js"></script>
        <script type="text/javascript">           
            function getUserData(){   
              	//这里的网址请根据自己情况来修改，具体使用方法请参考再下面的Js源码
                fetchApi("http://localhost/frame_test/public/getUserData").then(function(data){
                        console.log(data);
                    }
                );
            }
        </script>
    </head>
    <body>
        <input type="button" value="login" onclick="login('zeffee', '123456')">
        <input type="button" value="getUserData" onclick="getUserData()">
        <input type="button" value="logout" onclick="logout()">
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

### 最后说两句

    至此，您已经对框架的使用有一定的理解了，还有一些零碎的使用方法请阅读其他文档。

    声明：该例子的代码仅提供参考，未能达到产品级别。若某些地方存在错误，请大侠指出，谢谢。

​	