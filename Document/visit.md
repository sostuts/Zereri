## 访问

用浏览器访问前端文件或者控制器之前，先确保服务器的web服务**根目录**指向**/public/**  ,并且确保支持 **.htaccess**文件。

---

#### 访问前端文件

如：/public/  文件夹里面有  index.html ,  a.html

URL: http://www.example.com/   、 http://www.example.com/a.html



---

#### 访问控制器

`格式：http://domain/Class/method`

如：/App/Controllers/ 文件夹里面有 Test.php ，存在**today**方法。

URL: http://www.example.com/Test/today